<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RbacAndApprovalTest extends TestCase
{
    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);
    }

    public function test_admin_has_full_access()
    {
        $admin = User::where('email', 'admin@sekolah.sch.id')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->can('users.read'));
        $this->assertTrue($admin->can('berita.publish'));
        $this->assertTrue($admin->can('pengaturan.update'));

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
    }

    public function test_editor_can_publish_and_review_but_cannot_manage_users_or_settings()
    {
        $editor = User::where('email', 'editor@sekolah.sch.id')->first();
        $this->assertNotNull($editor);
        $this->assertTrue($editor->hasRole('editor'));
        $this->assertTrue($editor->can('berita.publish'));
        $this->assertTrue($editor->can('approvals.read'));
        $this->assertFalse($editor->can('users.read'));
        $this->assertFalse($editor->can('pengaturan.update'));

        $response = $this->actingAs($editor)->get(route('admin.approvals.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($editor)->get(route('admin.users.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($editor)->get(route('admin.settings.index'));
        $response->assertStatus(403);
    }

    public function test_staff_cannot_publish_directly_or_access_restricted_modules()
    {
        $staff = User::where('email', 'staff@sekolah.sch.id')->first();
        $this->assertNotNull($staff);
        $this->assertTrue($staff->hasRole('staff'));
        $this->assertTrue($staff->can('berita.create'));
        $this->assertTrue($staff->can('berita.read'));
        $this->assertFalse($staff->can('berita.publish'));
        $this->assertFalse($staff->can('users.read'));
        $this->assertFalse($staff->can('pengaturan.read'));
        $this->assertFalse($staff->can('approvals.read'));

        $response = $this->actingAs($staff)->get(route('admin.posts.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($staff)->get(route('admin.users.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->get(route('admin.approvals.index'));
        $response->assertStatus(403);
    }

    public function test_staff_post_forces_pending_review_and_editor_can_approve()
    {
        $staff = User::where('email', 'staff@sekolah.sch.id')->first();
        $editor = User::where('email', 'editor@sekolah.sch.id')->first();
        $category = Category::first() ?? Category::create(['name' => 'Umum', 'slug' => 'umum', 'is_active' => true]);

        // Staff attempts to create a post with status 'published'
        $response = $this->actingAs($staff)->post(route('admin.posts.store'), [
            'title' => 'Berita Kegiatan Staff',
            'slug' => 'berita-kegiatan-staff-' . time(),
            'content' => '<p>Konten berita kegiatan sekolah oleh staff.</p>',
            'excerpt' => 'Ringkasan singkat kegiatan staff.',
            'category_id' => $category->id,
            'status' => 'published', // Staff tries to publish directly
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        // Post should be forced to pending_review because staff does not have 'berita.publish'
        $post = Post::where('title', 'Berita Kegiatan Staff')->latest()->first();
        $this->assertNotNull($post);
        $this->assertEquals('pending_review', $post->status);

        // Editor approves the post
        $response = $this->actingAs($editor)->post(route('admin.approvals.posts.approve', $post));
        $response->assertRedirect();

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }
}
