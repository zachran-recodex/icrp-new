<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'address' => 'Jl. Thamrin No. 10, Jakarta Pusat 10230, Indonesia',
            'phone' => '+62-21-3190-4559',
            'email' => 'info@icrp.id',
            'social_links' => [
                'facebook' => 'https://facebook.com/icrp.indonesia',
                'twitter' => 'https://twitter.com/icrp_indonesia',
                'instagram' => 'https://instagram.com/icrp.indonesia',
                'youtube' => 'https://youtube.com/@icrp-indonesia'
            ],
            'footer_text' => 'Indonesian Conference on Religion and Peace (ICRP) adalah organisasi lintas agama yang berkomitmen untuk membangun perdamaian dan toleransi di Indonesia.',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
        ]);
    }
}
