<?php

namespace Tests\Feature;

use App\Models\SurveyResponse;
use App\Models\User;
use Tests\TestCase;

class SurveyTest extends TestCase
{
    public function test_survey_page_loads_successfully(): void
    {
        $response = $this->get(route('survey.index'));
        $response->assertStatus(200);
        $response->assertSee('Survei Kepuasan Masyarakat (SKM)');
        $response->assertSee('Persyaratan Pelayanan');
        $response->assertSee('Kirim Survei Sekarang');

    }

    public function test_survey_submission_succeeds_and_saves_to_database(): void
    {
        $data = [
            'respondent_role' => 'Orang Tua / Wali',
            'q1_rating' => 4,
            'q2_rating' => 4,
            'q3_rating' => 3,
            'q4_rating' => 4,
            'q5_rating' => 4,
            'q6_rating' => 4,
            'q7_rating' => 4,
            'q8_rating' => 3,
            'q9_rating' => 4,
            'improvement_suggestion' => 'Pelayanan sangat memuaskan dan petugas ramah.',
            'future_expectation' => 'Pertahankan prestasi dan keramahan.',
        ];

        $response = $this->post(route('survey.store'), $data);
        $response->assertRedirect(route('survey.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('survey_responses', [
            'respondent_role' => 'Orang Tua / Wali',
            'q1_rating' => 4,
            'improvement_suggestion' => 'Pelayanan sangat memuaskan dan petugas ramah.',
        ]);

        $survey = SurveyResponse::where('improvement_suggestion', 'Pelayanan sangat memuaskan dan petugas ramah.')->first();
        $this->assertNotNull($survey);
        $this->assertEquals(3.78, $survey->average_score);
        $ikm = SurveyResponse::convertToIkm($survey->average_score);
        $this->assertEquals(94.5, $ikm);
        $grade = SurveyResponse::getIkmGrade($ikm);
        $this->assertEquals('A', $grade['grade']);
        $this->assertEquals('Sangat Baik', $grade['performance']);

    }

    public function test_survey_submission_validation_fails_when_required_fields_missing(): void
    {
        $response = $this->post(route('survey.store'), []);
        $response->assertSessionHasErrors([
            'respondent_role',
            'q1_rating',
            'q2_rating',
            'q3_rating',
            'q4_rating',
            'q5_rating',
            'q6_rating',
            'q7_rating',
            'q8_rating',
            'q9_rating',
        ]);
    }


    public function test_admin_survey_dashboard_accessible_by_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.surveys.index'));
        $response->assertStatus(200);
        $response->assertSee('Survei Kepuasan Masyarakat');
        $response->assertSee('Nilai Konversi IKM');


        // Test print page
        $printResponse = $this->actingAs($admin)->get(route('admin.surveys.print'));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('LAPORAN HASIL PENGUKURAN SURVEI KEPUASAN MASYARAKAT');


        // Test export CSV
        $exportResponse = $this->actingAs($admin)->get(route('admin.surveys.export'));
        $exportResponse->assertStatus(200);
        $exportResponse->assertHeader('content-disposition');
    }

    public function test_admin_can_manage_survey_questions_crud(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // 1. Index page
        $indexResponse = $this->actingAs($admin)->get(route('admin.survey-questions.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Kelola Unsur');

        // 2. Create page
        $createResponse = $this->actingAs($admin)->get(route('admin.survey-questions.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Tambah Pertanyaan Kuesioner Baru');

        // 3. Store new question
        $storeResponse = $this->actingAs($admin)->post(route('admin.survey-questions.store'), [
            'order' => 10,
            'code' => 'U10',
            'title' => 'Inovasi Layanan Digital',
            'question' => 'Bagaimana kemudahan akses informasi melalui website dan portal digital sekolah?',
            'icon' => 'fas fa-laptop-code',
            'opt4_label' => 'Sangat Mudah',
            'opt3_label' => 'Mudah',
            'opt2_label' => 'Kurang Mudah',
            'opt1_label' => 'Tidak Mudah',
            'is_active' => '1',
        ]);
        $storeResponse->assertRedirect(route('admin.survey-questions.index'));
        $this->assertDatabaseHas('survey_questions', [
            'code' => 'U10',
            'title' => 'Inovasi Layanan Digital',
            'is_active' => true,
        ]);

        $question = \App\Models\SurveyQuestion::where('code', 'U10')->first();
        $this->assertNotNull($question);

        // 4. Edit page
        $editResponse = $this->actingAs($admin)->get(route('admin.survey-questions.edit', $question));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Edit Pertanyaan: Inovasi Layanan Digital');

        // 5. Update question
        $updateResponse = $this->actingAs($admin)->put(route('admin.survey-questions.update', $question), [
            'order' => 10,
            'code' => 'U10-REV',
            'title' => 'Inovasi Layanan Digital Terpadu',
            'question' => 'Bagaimana kemudahan akses informasi dan formulir online?',
            'icon' => 'fas fa-globe',
            'opt4_label' => 'Sangat Memuaskan',
            'opt3_label' => 'Memuaskan',
            'opt2_label' => 'Kurang Memuaskan',
            'opt1_label' => 'Tidak Memuaskan',
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.survey-questions.index'));
        $this->assertDatabaseHas('survey_questions', [
            'id' => $question->id,
            'code' => 'U10-REV',
            'title' => 'Inovasi Layanan Digital Terpadu',
        ]);

        // 6. Toggle status
        $toggleResponse = $this->actingAs($admin)->patch(route('admin.survey-questions.toggle-status', $question));
        $toggleResponse->assertRedirect();
        $this->assertDatabaseHas('survey_questions', [
            'id' => $question->id,
            'is_active' => false,
        ]);

        // 7. Delete question
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.survey-questions.destroy', $question));
        $deleteResponse->assertRedirect(route('admin.survey-questions.index'));
        $this->assertDatabaseMissing('survey_questions', [
            'id' => $question->id,
        ]);
    }
}
