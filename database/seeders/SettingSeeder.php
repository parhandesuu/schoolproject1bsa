<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'school_name', 'value' => 'SMA Negeri 1 Nusantara', 'type' => 'text', 'group' => 'general', 'label' => 'Nama Sekolah'],
            ['key' => 'school_short_name', 'value' => 'SMAN 1 Nusantara', 'type' => 'text', 'group' => 'general', 'label' => 'Nama Singkat Sekolah'],
            ['key' => 'school_motto', 'value' => 'Cerdas, Berkarakter, dan Berprestasi', 'type' => 'text', 'group' => 'general', 'label' => 'Motto Sekolah'],
            ['key' => 'school_description', 'value' => 'SMA Negeri 1 Nusantara adalah sekolah unggulan yang berkomitmen menghasilkan lulusan berkualitas dengan karakter mulia dan prestasi membanggakan.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Deskripsi Sekolah'],
            ['key' => 'school_npsn', 'value' => '20100001', 'type' => 'text', 'group' => 'general', 'label' => 'NPSN'],
            ['key' => 'school_accreditation', 'value' => 'A', 'type' => 'text', 'group' => 'general', 'label' => 'Akreditasi'],
            ['key' => 'school_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Logo Sekolah'],
            ['key' => 'school_favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],
            ['key' => 'primary_color', 'value' => '#1e40af', 'type' => 'text', 'group' => 'general', 'label' => 'Warna Utama'],

            // Contact
            ['key' => 'contact_address', 'value' => 'Jl. Pendidikan No. 1, Kecamatan Nusantara, Kabupaten Nusantara, Provinsi Indonesia 12345', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'contact_phone', 'value' => '(021) 1234-5678', 'type' => 'text', 'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'contact_whatsapp', 'value' => '628123456789', 'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'contact_email', 'value' => 'info@sman1nusantara.sch.id', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322327!2d106.8195613507864!3d-6.194809395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTEnNDEuMyJTIDEwNsKwNDknMTAuMiJF!5e0!3m2!1sen!2sid!4v1234567890', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Google Maps Embed URL'],

            // SEO
            ['key' => 'meta_title', 'value' => 'SMA Negeri 1 Nusantara - Cerdas, Berkarakter, dan Berprestasi', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Title'],
            ['key' => 'meta_description', 'value' => 'Website resmi SMA Negeri 1 Nusantara. Sekolah unggulan dengan akreditasi A yang berkomitmen menghasilkan lulusan berkualitas.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description'],
            ['key' => 'meta_keywords', 'value' => 'SMA Negeri 1 Nusantara, SMAN 1 Nusantara, sekolah nusantara, pendidikan', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Keywords'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
