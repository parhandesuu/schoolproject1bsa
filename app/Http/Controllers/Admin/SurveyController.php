<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyController extends Controller
{
    /**
     * Tampilkan dashboard statistik dan daftar respon SKM.
     */
    public function index(Request $request)
    {
        $roles = SurveyResponse::roles();
        $questions = SurveyResponse::questions();

        // Query dasar dengan filter
        $query = SurveyResponse::query();

        if ($role = $request->input('role')) {
            $query->where('respondent_role', $role);
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Hitung KPI
        $totalRespondents = (clone $query)->count();
        $allTimeTotal = SurveyResponse::count();
        $todayCount = SurveyResponse::whereDate('created_at', today())->count();
        $monthCount = SurveyResponse::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();

        $avgOverall = $totalRespondents > 0 ? (float) (clone $query)->avg('average_score') : 0;
        $ikmScore = SurveyResponse::convertToIkm($avgOverall);
        $ikmGrade = SurveyResponse::getIkmGrade($ikmScore);
        $satisfactionPercentage = round(($avgOverall / 4) * 100, 1);

        // Rekapitulasi Rata-rata per Unsur (Pertanyaan 1 - 9)
        $questionStats = [];
        $radarLabels = [];
        $radarData = [];

        foreach ($questions as $num => $q) {
            $qAvg = $totalRespondents > 0 ? (float) (clone $query)->avg("q{$num}_rating") : 0;
            $qIkm = SurveyResponse::convertToIkm($qAvg);
            $qGrade = SurveyResponse::getIkmGrade($qIkm);
            $qPercent = round(($qAvg / 4) * 100, 1);

            $questionStats[$num] = [
                'num'         => $num,
                'title'       => $q['title'],
                'question'    => $q['question'],
                'avg_score'   => round($qAvg, 2),
                'ikm'         => $qIkm,
                'grade'       => $qGrade,
                'percent'     => $qPercent,
            ];

            $radarLabels[] = "U{$num} (" . mb_strimwidth($q['title'], 0, 16, '...') . ")";
            $radarData[] = round($qAvg, 2);
        }

        // Distribusi Responden per Peran
        $roleDistribution = [];
        $roleChartLabels = [];
        $roleChartData = [];
        $roleColors = ['#1e40af', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'];

        foreach ($roles as $idx => $r) {
            $rCount = (clone $query)->where('respondent_role', $r)->count();
            $rPercent = $totalRespondents > 0 ? round(($rCount / $totalRespondents) * 100, 1) : 0;

            $roleDistribution[$r] = [
                'count'   => $rCount,
                'percent' => $rPercent,
                'color'   => $roleColors[$idx % count($roleColors)],
            ];

            $roleChartLabels[] = $r;
            $roleChartData[] = $rCount;
        }

        // Daftar Responden Paginated
        $responses = (clone $query)->latest()->paginate(15)->withQueryString();

        // Daftar Kritik, Saran & Harapan (Esai)
        $suggestions = (clone $query)
            ->where(function ($q) {
                $q->whereNotNull('improvement_suggestion')
                  ->where('improvement_suggestion', '!=', '')
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('future_expectation')
                         ->where('future_expectation', '!=', '');
                  });
            })
            ->latest()
            ->paginate(10, ['*'], 'suggestions_page')
            ->withQueryString();

        return view('admin.surveys.index', compact(
            'roles',
            'questions',
            'totalRespondents',
            'allTimeTotal',
            'todayCount',
            'monthCount',
            'avgOverall',
            'ikmScore',
            'ikmGrade',
            'satisfactionPercentage',
            'questionStats',
            'roleDistribution',
            'radarLabels',
            'radarData',
            'roleChartLabels',
            'roleChartData',
            'responses',
            'suggestions'
        ));
    }

    /**
     * Tampilkan detail respon tunggal (JSON untuk modal).
     */
    public function show(SurveyResponse $survey)
    {
        $questions = SurveyResponse::questions();
        $detail = [];

        foreach ($questions as $num => $q) {
            $val = $survey->{"q{$num}_rating"};
            $opt = $q['options'][$val] ?? null;
            $detail[] = [
                'num'      => $num,
                'title'    => $q['title'],
                'question' => $q['question'],
                'score'    => $val,
                'label'    => $opt['label'] ?? '-',
            ];
        }

        return response()->json([
            'id'                     => $survey->id,
            'respondent_role'        => $survey->respondent_role,
            'average_score'          => $survey->average_score,
            'ikm_score'              => SurveyResponse::convertToIkm($survey->average_score),
            'improvement_suggestion' => $survey->improvement_suggestion ?: '-',
            'future_expectation'     => $survey->future_expectation ?: '-',
            'ip_address'             => $survey->ip_address ?: '-',
            'created_at'             => $survey->created_at->translatedFormat('d F Y H:i'),
            'answers'                => $detail,
        ]);
    }

    /**
     * Hapus respon kuesioner.
     */
    public function destroy(SurveyResponse $survey)
    {
        $survey->delete();

        return redirect()->back()->with('success', 'Data respon kuesioner berhasil dihapus.');
    }

    /**
     * Export hasil kuesioner ke file Excel / CSV.
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = SurveyResponse::query();

        if ($role = $request->input('role')) {
            $query->where('respondent_role', $role);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $records = $query->latest()->get();
        $fileName = 'Laporan_Survei_SKM_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        return response()->stream(function () use ($records) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($handle, [
                'ID Respon',
                'Tanggal Pengisian',
                'Peran Responden',
                'U1: Kesesuaian Persyaratan (1-4)',
                'U2: Kemudahan Prosedur (1-4)',
                'U3: Kecepatan Waktu (1-4)',
                'U4: Kewajaran Biaya (1-4)',
                'U5: Kesesuaian Hasil (1-4)',
                'U6: Kompetensi Petugas (1-4)',
                'U7: Perilaku Petugas (1-4)',
                'U8: Kualitas Sarpras (1-4)',
                'U9: Penanganan Pengaduan (1-4)',
                'Nilai Rata-rata (Skala 1-4)',
                'Nilai Konversi IKM (25-100)',
                'Mutu Pelayanan',
                'Saran Perbaikan Pelayanan',
                'Harapan Tahun Ajaran Baru',
                'IP Address',
            ]);

            foreach ($records as $row) {
                $ikm = SurveyResponse::convertToIkm($row->average_score);
                $grade = SurveyResponse::getIkmGrade($ikm);

                fputcsv($handle, [
                    $row->id,
                    $row->created_at->format('Y-m-d H:i:s'),
                    $row->respondent_role,
                    $row->q1_rating,
                    $row->q2_rating,
                    $row->q3_rating,
                    $row->q4_rating,
                    $row->q5_rating,
                    $row->q6_rating,
                    $row->q7_rating,
                    $row->q8_rating,
                    $row->q9_rating,
                    $row->average_score,
                    $ikm,
                    $grade['performance'] . ' (' . $grade['grade'] . ')',
                    $row->improvement_suggestion,
                    $row->future_expectation,
                    $row->ip_address,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Tampilan cetak resmi / export PDF.
     */
    public function print(Request $request)
    {
        $query = SurveyResponse::query();

        if ($role = $request->input('role')) {
            $query->where('respondent_role', $role);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $totalRespondents = $query->count();
        $avgOverall = $totalRespondents > 0 ? (float) (clone $query)->avg('average_score') : 0;
        $ikmScore = SurveyResponse::convertToIkm($avgOverall);
        $ikmGrade = SurveyResponse::getIkmGrade($ikmScore);

        $questions = SurveyResponse::questions();
        $questionStats = [];

        foreach ($questions as $num => $q) {
            $qAvg = $totalRespondents > 0 ? (float) (clone $query)->avg("q{$num}_rating") : 0;
            $qIkm = SurveyResponse::convertToIkm($qAvg);
            $qGrade = SurveyResponse::getIkmGrade($qIkm);

            $questionStats[$num] = [
                'title'     => $q['title'],
                'question'  => $q['question'],
                'avg_score' => round($qAvg, 2),
                'ikm'       => $qIkm,
                'grade'     => $qGrade,
            ];
        }

        $roles = SurveyResponse::roles();
        $roleDistribution = [];
        foreach ($roles as $r) {
            $count = (clone $query)->where('respondent_role', $r)->count();
            $percent = $totalRespondents > 0 ? round(($count / $totalRespondents) * 100, 1) : 0;
            $roleDistribution[$r] = [
                'count'   => $count,
                'percent' => $percent,
            ];
        }

        $settings = Setting::pluck('value', 'key');
        $responses = $query->latest()->limit(50)->get();

        return view('admin.surveys.print', compact(
            'totalRespondents',
            'avgOverall',
            'ikmScore',
            'ikmGrade',
            'questions',
            'questionStats',
            'roleDistribution',
            'settings',
            'responses',
            'request'
        ));
    }
}
