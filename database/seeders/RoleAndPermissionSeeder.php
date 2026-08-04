<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions list by module
        $modules = [
            'hero-slider'     => ['create', 'read', 'update', 'delete'],
            'statistik'       => ['create', 'read', 'update', 'delete'],
            'layanan'         => ['create', 'read', 'update', 'delete'],
            'media-sosial'    => ['create', 'read', 'update', 'delete'],
            'pengaturan'      => ['read', 'update'],
            'settings'        => ['read', 'update'],
            'users'           => ['create', 'read', 'update', 'delete'],
            'berita'          => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'kategori'        => ['create', 'read', 'update', 'delete'],
            'kategori-berita' => ['create', 'read', 'update', 'delete'],
            'agenda'          => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'pengumuman'      => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'fasilitas'       => ['create', 'read', 'update', 'delete'],
            'ekstrakurikuler' => ['create', 'read', 'update', 'delete'],
            'prestasi'        => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'galeri-foto'     => ['create', 'read', 'update', 'delete'],
            'galeri-video'    => ['create', 'read', 'update', 'delete'],
            'dokumen'         => ['create', 'read', 'update', 'delete'],
            'halaman'         => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'halaman-statis'  => ['create', 'read', 'update', 'delete', 'publish', 'approve'],
            'staff-guru'      => ['create', 'read', 'update', 'delete'],
            'guru'            => ['create', 'read', 'update', 'delete'],
            'komentar'        => ['read', 'approve', 'reject', 'delete'],
            'kontak'          => ['read', 'mark-read', 'delete'],
            'activity-log'    => ['read'],
            'approvals'       => ['read', 'approve', 'reject'],
            'notifications'   => ['read', 'delete'],
        ];

        // Create all permissions
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web'
                ]);
            }
        }

        // 1. ROLE ADMIN (Akses Penuh Seluruh Modul)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2. ROLE EDITOR (Kelola & Publish Konten, Approval, Moderasi)
        $editorPermissions = [
            // Berita & Kategori: Full + Publish + Approve
            'berita.create', 'berita.read', 'berita.update', 'berita.delete', 'berita.publish', 'berita.approve',
            'kategori.create', 'kategori.read', 'kategori.update',
            'kategori-berita.create', 'kategori-berita.read', 'kategori-berita.update',
            // Agenda: Full
            'agenda.create', 'agenda.read', 'agenda.update', 'agenda.delete', 'agenda.publish', 'agenda.approve',
            // Pengumuman: Full
            'pengumuman.create', 'pengumuman.read', 'pengumuman.update', 'pengumuman.delete', 'pengumuman.publish', 'pengumuman.approve',
            // Fasilitas: Full
            'fasilitas.create', 'fasilitas.read', 'fasilitas.update', 'fasilitas.delete',
            // Ekstrakurikuler: Full
            'ekstrakurikuler.create', 'ekstrakurikuler.read', 'ekstrakurikuler.update', 'ekstrakurikuler.delete',
            // Prestasi: Full
            'prestasi.create', 'prestasi.read', 'prestasi.update', 'prestasi.delete', 'prestasi.publish', 'prestasi.approve',
            // Galeri Foto & Video: Full
            'galeri-foto.create', 'galeri-foto.read', 'galeri-foto.update', 'galeri-foto.delete',
            'galeri-video.create', 'galeri-video.read', 'galeri-video.update', 'galeri-video.delete',
            // Dokumen: Full
            'dokumen.create', 'dokumen.read', 'dokumen.update', 'dokumen.delete',
            // Halaman Statis: Edit & Publish
            'halaman.read', 'halaman.update', 'halaman.publish', 'halaman.approve',
            'halaman-statis.read', 'halaman-statis.update', 'halaman-statis.publish', 'halaman-statis.approve',
            // Staff & Guru: Buat, Edit (Tanpa Hapus)
            'staff-guru.create', 'staff-guru.read', 'staff-guru.update',
            'guru.create', 'guru.read', 'guru.update',
            // Komentar: Moderasi Penuh
            'komentar.read', 'komentar.approve', 'komentar.reject', 'komentar.delete',
            // Kontak: Lihat & Balas / Tandai
            'kontak.read', 'kontak.mark-read',
            // Approval & Notifikasi
            'approvals.read', 'approvals.approve', 'approvals.reject',
            'notifications.read', 'notifications.delete',
            // Slider & Statistik dasar untuk editor
            'hero-slider.read', 'statistik.read', 'layanan.read', 'media-sosial.read',
        ];
        $editorRole = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->syncPermissions($editorPermissions);

        // 3. ROLE STAFF (Operasional Konten: Buat & Ajukan Draft)
        $staffPermissions = [
            // Berita: Buat & Edit (Draft/Review)
            'berita.create', 'berita.read', 'berita.update',
            // Agenda: Buat & Edit
            'agenda.create', 'agenda.read', 'agenda.update',
            // Pengumuman: Buat & Edit
            'pengumuman.create', 'pengumuman.read', 'pengumuman.update',
            // Prestasi: Buat & Edit
            'prestasi.create', 'prestasi.read', 'prestasi.update',
            // Galeri Foto: Full
            'galeri-foto.create', 'galeri-foto.read', 'galeri-foto.update', 'galeri-foto.delete',
            // Galeri Video: Buat & Edit (Tanpa Hapus)
            'galeri-video.create', 'galeri-video.read', 'galeri-video.update',
            // Dokumen: Buat & Edit (Tanpa Hapus)
            'dokumen.create', 'dokumen.read', 'dokumen.update',
            // Komentar: Lihat & Approve
            'komentar.read', 'komentar.approve',
            // Kontak: Lihat & Tandai
            'kontak.read', 'kontak.mark-read',
            // Notifikasi
            'notifications.read',
        ];
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staffRole->syncPermissions($staffPermissions);

        // Default Users Creation / Sync
        $admin = User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $editor = User::updateOrCreate(
            ['email' => 'editor@sekolah.sch.id'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('Editor@12345'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );
        $editor->syncRoles(['editor']);

        $staff = User::updateOrCreate(
            ['email' => 'staff@sekolah.sch.id'],
            [
                'name' => 'Staff Operasional',
                'password' => Hash::make('Staff@12345'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
        $staff->syncRoles(['staff']);

        // Sync all other users
        $allUsers = User::all();
        foreach ($allUsers as $u) {
            if ($u->role === 'admin' && !$u->hasRole('admin')) {
                $u->assignRole('admin');
            } elseif ($u->role === 'editor' && !$u->hasRole('editor')) {
                $u->assignRole('editor');
            } elseif ($u->role === 'staff' && !$u->hasRole('staff')) {
                $u->assignRole('staff');
            }
        }
    }
}
