<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Tampilkan formulir kuesioner Survei Kepuasan Masyarakat (SKM).
     */
    public function index()
    {
        $roles = SurveyResponse::roles();
        $questions = SurveyResponse::questions();
        $totalRespondents = SurveyResponse::count();

        // Hitung nilai IKM agregat saat ini jika ada responden
        $overallIkm = null;
        $ikmGrade = null;
        if ($totalRespondents > 0) {
            $avgScore = (float) SurveyResponse::avg('average_score');
            $overallIkm = SurveyResponse::convertToIkm($avgScore);
            $ikmGrade = SurveyResponse::getIkmGrade($overallIkm);
        }

        return view('survey.index', compact('roles', 'questions', 'totalRespondents', 'overallIkm', 'ikmGrade'));
    }

    /**
     * Simpan respon kuesioner ke database (Anonim).
     */
    public function store(Request $request)
    {
        $questions = SurveyResponse::questions();
        $roles = SurveyResponse::roles();

        $rules = [
            'respondent_role'        => ['required', 'string', 'in:' . implode(',', $roles)],
            'improvement_suggestion' => ['nullable', 'string', 'max:3000'],
            'future_expectation'     => ['nullable', 'string', 'max:3000'],
        ];

        $customMessages = [
            'respondent_role.required' => 'Mohon pilih peran Anda terlebih dahulu.',
            'respondent_role.in'       => 'Pilihan peran tidak valid.',
        ];

        foreach ($questions as $num => $q) {
            $rules["q{$num}_rating"] = ['required', 'integer', 'between:1,4'];
            $customMessages["q{$num}_rating.required"] = "Pertanyaan nomor {$num} ({$q['title']}) wajib diisi.";
            $customMessages["q{$num}_rating.between"] = "Penilaian pertanyaan nomor {$num} harus bernilai antara 1 sampai 4.";
        }

        $validated = $request->validate($rules, $customMessages);

        $sum = 0;
        $totalQuestions = count($questions);
        $answersDetail = [];

        foreach ($questions as $num => $q) {
            $ratingVal = (int) $validated["q{$num}_rating"];
            $sum += $ratingVal;
            $optLabel = $q['options'][$ratingVal]['label'] ?? "Skala {$ratingVal}";

            $answersDetail[] = [
                'number'         => $num,
                'question_id'    => $q['id'] ?? null,
                'code'           => $q['code'] ?? ('U' . $num),
                'title'          => $q['title'],
                'question'       => $q['question'],
                'rating'         => $ratingVal,
                'selected_label' => $optLabel,
            ];
        }

        $averageScore = $totalQuestions > 0 ? round($sum / $totalQuestions, 2) : 0;

        SurveyResponse::create([
            'respondent_role'        => $validated['respondent_role'],
            'q1_rating'              => (int) ($validated['q1_rating'] ?? ($answersDetail[0]['rating'] ?? 4)),
            'q2_rating'              => (int) ($validated['q2_rating'] ?? ($answersDetail[1]['rating'] ?? 4)),
            'q3_rating'              => (int) ($validated['q3_rating'] ?? ($answersDetail[2]['rating'] ?? 4)),
            'q4_rating'              => (int) ($validated['q4_rating'] ?? ($answersDetail[3]['rating'] ?? 4)),
            'q5_rating'              => (int) ($validated['q5_rating'] ?? ($answersDetail[4]['rating'] ?? 4)),
            'q6_rating'              => (int) ($validated['q6_rating'] ?? ($answersDetail[5]['rating'] ?? 4)),
            'q7_rating'              => (int) ($validated['q7_rating'] ?? ($answersDetail[6]['rating'] ?? 4)),
            'q8_rating'              => (int) ($validated['q8_rating'] ?? ($answersDetail[7]['rating'] ?? 4)),
            'q9_rating'              => (int) ($validated['q9_rating'] ?? ($answersDetail[8]['rating'] ?? 4)),
            'average_score'          => $averageScore,
            'answers'                => $answersDetail,
            'improvement_suggestion' => $validated['improvement_suggestion'] ?? null,
            'future_expectation'     => $validated['future_expectation'] ?? null,
            'ip_address'             => $request->ip(),
            'user_agent'             => $request->userAgent(),
        ]);

        return redirect()
            ->route('survey.index')
            ->with('survey_submitted', true)
            ->with('success', 'Terima kasih atas partisipasi Anda dalam mengisi Survei Kepuasan Masyarakat!');
    }
}

