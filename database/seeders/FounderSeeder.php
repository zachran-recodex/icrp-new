<?php

namespace Database\Seeders;

use App\Models\Founder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FounderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $founders = [
            [
                'name' => 'Dr. Djohan Effendi',
                'nickname' => null,
                'birth_date' => '1939-07-15',
                'death_date' => '2020-11-30',
                'birth_place' => 'Batavia, Hindia Belanda',
                'known_as' => 'Tokoh Dialog Antar Agama',
                'quote' => 'Keragaman adalah rahmat, bukan ancaman.',
                'biography' => 'Dr. Djohan Effendi adalah seorang intelektual Muslim yang dikenal sebagai pelopor dialog antar agama di Indonesia. Beliau memiliki peran penting dalam pembentukan ICRP dan selalu mempromosikan toleransi beragama.',
                'image' => 'founder-djohan.jpg',
                'order' => 1,
                'contributions' => [
                    [
                        'title' => 'Pelopor Dialog Antar Agama',
                        'description' => 'Memulai gerakan dialog konstruktif antar pemeluk agama di Indonesia sejak era 1970-an.',
                        'order' => 1
                    ],
                    [
                        'title' => 'Penulis Buku Toleransi',
                        'description' => 'Menulis berbagai karya tentang pluralisme dan toleransi beragama.',
                        'order' => 2
                    ]
                ],
                'legacies' => [
                    'Pemikiran tentang pentingnya dialog dalam membangun perdamaian antar umat beragama.',
                    'Konsep pluralisme agama yang inklusif dan menghormati perbedaan.'
                ]
            ],
            [
                'name' => 'Prof. Dr. Komaruddin Hidayat',
                'nickname' => null,
                'birth_date' => '1953-04-12',
                'death_date' => null,
                'birth_place' => 'Jakarta, Indonesia',
                'known_as' => 'Akademisi dan Pemikir Islam',
                'quote' => 'Agama sejati adalah yang mengajarkan kasih sayang kepada semua makhluk.',
                'biography' => 'Prof. Komaruddin Hidayat adalah akademisi dan pemikir Islam Indonesia. Beliau dikenal karena pemikirannya yang progresif tentang Islam dan hubungan antar agama.',
                'image' => 'founder-komaruddin.jpg',
                'order' => 2,
                'contributions' => [
                    [
                        'title' => 'Pengembangan Studi Islam',
                        'description' => 'Berkontribusi dalam pengembangan studi Islam kontemporer di Indonesia.',
                        'order' => 1
                    ],
                    [
                        'title' => 'Moderasi Beragama',
                        'description' => 'Mempromosikan konsep moderasi dalam beragama melalui berbagai karya tulis.',
                        'order' => 2
                    ]
                ],
                'legacies' => [
                    'Pengembangan pemikiran Islam yang moderat dan inklusif.',
                    'Kontribusi dalam dunia akademik melalui penelitian dan publikasi.'
                ]
            ]
        ];

        foreach ($founders as $founderData) {
            $contributions = $founderData['contributions'];
            $legacies = $founderData['legacies'];
            unset($founderData['contributions'], $founderData['legacies']);

            $founder = Founder::create($founderData);

            foreach ($contributions as $contribution) {
                $founder->contributions()->create($contribution);
            }

            foreach ($legacies as $legacy) {
                $founder->legacies()->create(['content' => $legacy]);
            }
        }
    }
}
