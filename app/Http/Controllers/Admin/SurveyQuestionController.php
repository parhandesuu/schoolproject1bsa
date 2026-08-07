<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    /**
     * Tampilkan daftar pertanyaan survei SKM.
     */
    public function index(Request $request)
    {
        $query = SurveyQuestion::query()->ordered();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('question', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('is_active', $request->boolean('status'));
        }

        $questions = $query->paginate(15)->withQueryString();

        $totalCount = SurveyQuestion::count();
        $activeCount = SurveyQuestion::where('is_active', true)->count();
        $inactiveCount = SurveyQuestion::where('is_active', false)->count();

        return view('admin.surveys.questions.index', compact(
            'questions',
            'totalCount',
            'activeCount',
            'inactiveCount'
        ));
    }

    /**
     * Tampilkan formulir tambah pertanyaan baru.
     */
    public function create()
    {
        $nextOrder = (SurveyQuestion::max('order') ?? 0) + 1;
        $suggestedCode = 'U' . $nextOrder;

        return view('admin.surveys.questions.create', compact('nextOrder', 'suggestedCode'));
    }

    /**
     * Simpan pertanyaan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order'       => ['required', 'integer', 'min:1'],
            'code'        => ['nullable', 'string', 'max:20'],
            'title'       => ['required', 'string', 'max:255'],
            'question'    => ['required', 'string', 'max:3000'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'opt1_label'  => ['required', 'string', 'max:150'],
            'opt2_label'  => ['required', 'string', 'max:150'],
            'opt3_label'  => ['required', 'string', 'max:150'],
            'opt4_label'  => ['required', 'string', 'max:150'],
            'is_active'   => ['nullable'],
        ], [
            'title.required'      => 'Judul unsur pertanyaan wajib diisi.',
            'question.required'   => 'Teks pertanyaan kuesioner wajib diisi.',
            'opt1_label.required' => 'Label opsi nilai 1 wajib diisi.',
            'opt2_label.required' => 'Label opsi nilai 2 wajib diisi.',
            'opt3_label.required' => 'Label opsi nilai 3 wajib diisi.',
            'opt4_label.required' => 'Label opsi nilai 4 wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['icon'] = $validated['icon'] ?: 'fas fa-clipboard-check';

        SurveyQuestion::create($validated);

        return redirect()
            ->route('admin.survey-questions.index')
            ->with('success', 'Pertanyaan survei berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir edit pertanyaan.
     */
    public function edit(SurveyQuestion $surveyQuestion)
    {
        return view('admin.surveys.questions.edit', compact('surveyQuestion'));
    }

    /**
     * Perbarui data pertanyaan di database.
     */
    public function update(Request $request, SurveyQuestion $surveyQuestion)
    {
        $validated = $request->validate([
            'order'       => ['required', 'integer', 'min:1'],
            'code'        => ['nullable', 'string', 'max:20'],
            'title'       => ['required', 'string', 'max:255'],
            'question'    => ['required', 'string', 'max:3000'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'opt1_label'  => ['required', 'string', 'max:150'],
            'opt2_label'  => ['required', 'string', 'max:150'],
            'opt3_label'  => ['required', 'string', 'max:150'],
            'opt4_label'  => ['required', 'string', 'max:150'],
            'is_active'   => ['nullable'],
        ], [
            'title.required'      => 'Judul unsur pertanyaan wajib diisi.',
            'question.required'   => 'Teks pertanyaan kuesioner wajib diisi.',
            'opt1_label.required' => 'Label opsi nilai 1 wajib diisi.',
            'opt2_label.required' => 'Label opsi nilai 2 wajib diisi.',
            'opt3_label.required' => 'Label opsi nilai 3 wajib diisi.',
            'opt4_label.required' => 'Label opsi nilai 4 wajib diisi.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;
        $validated['icon'] = $validated['icon'] ?: 'fas fa-clipboard-check';

        $surveyQuestion->update($validated);

        return redirect()
            ->route('admin.survey-questions.index')
            ->with('success', 'Pertanyaan survei berhasil diperbarui!');
    }

    /**
     * Hapus pertanyaan dari database.
     */
    public function destroy(SurveyQuestion $surveyQuestion)
    {
        $surveyQuestion->delete();

        return redirect()
            ->route('admin.survey-questions.index')
            ->with('success', 'Pertanyaan survei berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif pertanyaan.
     */
    public function toggleStatus(SurveyQuestion $surveyQuestion)
    {
        $surveyQuestion->is_active = !$surveyQuestion->is_active;
        $surveyQuestion->save();

        $statusText = $surveyQuestion->is_active ? 'diaktifkan' : 'dinonaktifkan';

        if (request()->wantsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => $surveyQuestion->is_active,
                'message'   => "Pertanyaan berhasil {$statusText}.",
            ]);
        }

        return redirect()
            ->back()
            ->with('success', "Pertanyaan berhasil {$statusText}.");
    }
}
