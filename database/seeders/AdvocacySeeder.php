<?php

namespace Database\Seeders;

use App\Models\Advocacy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdvocacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advocacies = [
            [
                'title' => 'Advokasi Kebebasan Beragama',
                'content' => 'ICRP berkomitmen untuk mengadvokasi kebebasan beragama dan berkeyakinan di Indonesia. Kami percaya bahwa setiap individu memiliki hak untuk memeluk dan menjalankan agamanya tanpa diskriminasi atau intimidasi...',
                'image' => 'advocacy-religious-freedom.jpg'
            ],
            [
                'title' => 'Kampanye Anti-Diskriminasi',
                'content' => 'Melalui berbagai kegiatan kampanye, ICRP berupaya mengurangi diskriminasi berbasis agama di masyarakat. Kami bekerja sama dengan berbagai pihak untuk menciptakan lingkungan yang inklusif...',
                'image' => 'advocacy-anti-discrimination.jpg'
            ],
            [
                'title' => 'Perlindungan Tempat Ibadah',
                'content' => 'ICRP aktif mengadvokasi perlindungan tempat-tempat ibadah dari berbagai ancaman. Kami percaya bahwa tempat ibadah adalah ruang suci yang harus dihormati oleh semua pihak...',
                'image' => 'advocacy-worship-protection.jpg'
            ]
        ];

        foreach ($advocacies as $advocacy) {
            Advocacy::create($advocacy);
        }
    }
}
