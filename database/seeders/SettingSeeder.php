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
            ['key' => 'school_name', 'value' => 'UPT SMP Negeri 1 Buay Sandang Aji', 'type' => 'text', 'group' => 'general', 'label' => 'Nama Sekolah'],
            ['key' => 'school_short_name', 'value' => 'SMPN 1 Buay Sandang Aji', 'type' => 'text', 'group' => 'general', 'label' => 'Nama Singkat Sekolah'],
            ['key' => 'school_motto', 'value' => 'Berakhlakul Karimah, Sukses, Berprestasi, dan Andal (B-S-B-A)', 'type' => 'text', 'group' => 'general', 'label' => 'Motto Sekolah'],
            ['key' => 'school_description', 'value' => 'UPT SMP Negeri 1 Buay Sandang Aji adalah satuan pendidikan formal jenjang SMP di Kabupaten Ogan Komering Ulu Selatan yang berkomitmen mewujudkan generasi cerdas, berkarakter, dan berdaya saing berlandaskan 4 pilar utama: Berakhlakul Karimah, Sukses, Berprestasi, dan Andal.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Deskripsi Sekolah'],
            ['key' => 'school_npsn', 'value' => '10604104', 'type' => 'text', 'group' => 'general', 'label' => 'NPSN'],
            ['key' => 'school_nss', 'value' => '201110800001', 'type' => 'text', 'group' => 'general', 'label' => 'NSS'],
            ['key' => 'school_accreditation', 'value' => 'B', 'type' => 'text', 'group' => 'general', 'label' => 'Akreditasi'],
            ['key' => 'school_principal', 'value' => 'Rosidah, S.Pd', 'type' => 'text', 'group' => 'general', 'label' => 'Kepala Sekolah'],
            ['key' => 'school_principal_nip', 'value' => '197005171997022002', 'type' => 'text', 'group' => 'general', 'label' => 'NIP Kepala Sekolah'],
            ['key' => 'school_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Logo Sekolah'],
            ['key' => 'school_favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],
            ['key' => 'primary_color', 'value' => '#1e40af', 'type' => 'text', 'group' => 'general', 'label' => 'Warna Utama'],

            // Contact
            ['key' => 'contact_address', 'value' => 'Jl. Raya Kenali RT 01 RW 01, Desa Gunung Terang, Kec. Buay Sandang Aji, Kab. Ogan Komering Ulu Selatan, Sumatera Selatan 32252', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'contact_phone', 'value' => '(0735) 7328001', 'type' => 'text', 'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'contact_whatsapp', 'value' => '6282178901234', 'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'contact_email', 'value' => 'smpn1buaysandangaji@gmail.com', 'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127144.15347271457!2d103.951171!3d-4.839213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e39c4d98a0058b7%3A0x6b77209dfa996f01!2sKec.%20Buay%20Sandang%20Aji%2C%20Kabupaten%20Ogan%20Komering%20Ulu%20Selatan%2C%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Google Maps Embed URL'],

            // SEO
            ['key' => 'meta_title', 'value' => 'UPT SMP Negeri 1 Buay Sandang Aji - Berakhlakul Karimah, Sukses, Berprestasi, dan Andal', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Title'],
            ['key' => 'meta_description', 'value' => 'Website resmi UPT SMP Negeri 1 Buay Sandang Aji. Satuan pendidikan menengah pertama di Kec. Buay Sandang Aji, Kab. OKU Selatan.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description'],
            ['key' => 'meta_keywords', 'value' => 'SMPN 1 Buay Sandang Aji, SMP Negeri 1 Buay Sandang Aji, SMP OKU Selatan, Pendidikan Buay Sandang Aji, Sekolah B-S-B-A', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Keywords'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

