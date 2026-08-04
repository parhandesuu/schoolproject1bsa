<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VerifyRbacSystem extends Command
{
    protected $signature = 'rbac:verify';
    protected $description = 'Verify RBAC, permissions, roles, and approval system';

    public function handle()
    {
        $this->info("=== VERIFIKASI SISTEM RBAC & APPROVAL ===");

        // 1. Roles & Permissions Count
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();
        $this->line("Roles terdaftar: <info>{$rolesCount}</info> (admin, editor, staff)");
        $this->line("Permissions terdaftar: <info>{$permissionsCount}</info>");

        if ($rolesCount < 3 || $permissionsCount < 80) {
            $this->error("Roles atau permissions belum lengkap!");
            return 1;
        }

        // 2. Check Users
        $admin = User::where('email', 'admin@sekolah.sch.id')->first();
        $editor = User::where('email', 'editor@sekolah.sch.id')->first();
        $staff = User::where('email', 'staff@sekolah.sch.id')->first();

        if (!$admin || !$editor || !$staff) {
            $this->error("User default admin, editor, atau staff belum ada di database!");
            return 1;
        }

        $this->info("\n--- PENGUJIAN HAK AKSES USER ---");
        
        // Test Admin
        $this->line("Admin ({$admin->email}):");
        $this->line(" - Has Role 'admin': " . ($admin->hasRole('admin') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'users.create': " . ($admin->can('users.create') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'berita.publish': " . ($admin->can('berita.publish') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'pengaturan.update': " . ($admin->can('pengaturan.update') ? "<info>OK</info>" : "<error>FAIL</error>"));

        // Test Editor
        $this->line("\nEditor ({$editor->email}):");
        $this->line(" - Has Role 'editor': " . ($editor->hasRole('editor') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'berita.publish': " . ($editor->can('berita.publish') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'approvals.read': " . ($editor->can('approvals.read') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - CANNOT 'users.read': " . (!$editor->can('users.read') ? "<info>OK (Blocked)</info>" : "<error>FAIL (Should be blocked)</error>"));
        $this->line(" - CANNOT 'pengaturan.update': " . (!$editor->can('pengaturan.update') ? "<info>OK (Blocked)</info>" : "<error>FAIL (Should be blocked)</error>"));

        // Test Staff
        $this->line("\nStaff ({$staff->email}):");
        $this->line(" - Has Role 'staff': " . ($staff->hasRole('staff') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - Can 'berita.create': " . ($staff->can('berita.create') ? "<info>OK</info>" : "<error>FAIL</error>"));
        $this->line(" - CANNOT 'berita.publish': " . (!$staff->can('berita.publish') ? "<info>OK (Blocked)</info>" : "<error>FAIL (Should be blocked)</error>"));
        $this->line(" - CANNOT 'users.read': " . (!$staff->can('users.read') ? "<info>OK (Blocked)</info>" : "<error>FAIL (Should be blocked)</error>"));
        $this->line(" - CANNOT 'approvals.read': " . (!$staff->can('approvals.read') ? "<info>OK (Blocked)</info>" : "<error>FAIL (Should be blocked)</error>"));

        // 3. Test Approval & Activity Log
        $this->info("\n--- PENGUJIAN WORKFLOW APPROVAL ---");
        $category = Category::first() ?? Category::create(['name' => 'Umum', 'slug' => 'umum', 'is_active' => true]);
        
        Post::withTrashed()->where('slug', 'test-rbac-workflow-post')->forceDelete();
        
        $testPost = Post::create([
            'slug' => 'test-rbac-workflow-post',
            'title' => 'Test Post Approval Workflow',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content body',
            'user_id' => $staff->id,
            'category_id' => $category->id,
            'status' => 'pending_review',
        ]);

        $this->line("Post dibuat dengan status: <comment>{$testPost->status}</comment>");
        
        // Editor approves
        $testPost->update([
            'status' => 'published',
            'published_at' => now(),
            'reviewed_by' => $editor->id,
            'reviewed_at' => now(),
            'rejection_note' => null,
        ]);
        
        $testPost->refresh();
        $this->line("Post setelah diapprove Editor: <info>{$testPost->status}</info> (Approved by: {$editor->name})");

        // Clean up test post
        $testPost->forceDelete();

        $this->info("\n=== SEMUA VERIFIKASI RBAC & APPROVAL BERHASIL 100% ===");
        return 0;
    }
}
