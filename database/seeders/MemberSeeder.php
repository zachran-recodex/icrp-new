<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Dr. Ahmad Syafii Maarif',
                'nickname' => null,
                'birth_date' => '1935-05-31',
                'death_date' => '2022-05-31',
                'birth_place' => 'Sumpur Kudus, Sumatra Barat',
                'known_as' => 'Cendekiawan Muslim dan Budayawan',
                'quote' => 'Islam harus menjadi rahmat bagi seluruh alam.',
                'biography' => 'Dr. Ahmad Syafii Maarif adalah seorang cendekiawan Muslim, budayawan, dan mantan Ketua Umum Pimpinan Pusat Muhammadiyah.',
                'image' => 'member-syafii.jpg',
                'order' => 1,
                'position' => 'Ketua Dewan Pembina',
                'dewan' => 'Pembina',
                'contributions' => [
                    [
                        'title' => 'Pembaharuan Pemikiran Islam',
                        'description' => 'Memperjuangkan pembaharuan dalam pemikiran Islam Indonesia.',
                        'order' => 1
                    ]
                ],
                'legacies' => [
                    'Pemikiran tentang Islam yang progresif dan humanis.'
                ]
            ],
            [
                'name' => 'Pastor Dr. Andreas A. Yewangoe',
                'nickname' => null,
                'birth_date' => '1942-08-15',
                'death_date' => null,
                'birth_place' => 'Minahasa, Sulawesi Utara',
                'known_as' => 'Teolog Kristen dan Aktivis Dialog',
                'quote' => 'Kekristenan sejati adalah yang membawa damai.',
                'biography' => 'Pastor Dr. Andreas A. Yewangoe adalah seorang teolog Kristen Indonesia yang aktif dalam dialog antar agama.',
                'image' => 'member-yewangoe.jpg',
                'order' => 2,
                'position' => 'Wakil Ketua Dewan Pembina',
                'dewan' => 'Pembina',
                'contributions' => [
                    [
                        'title' => 'Dialog Teologi Antar Agama',
                        'description' => 'Mengembangkan dialog teologi antara Kristen dan agama lain.',
                        'order' => 1
                    ]
                ],
                'legacies' => [
                    'Pengembangan teologi kontekstual Indonesia.'
                ]
            ]
        ];

        foreach ($members as $memberData) {
            $contributions = $memberData['contributions'];
            $legacies = $memberData['legacies'];
            unset($memberData['contributions'], $memberData['legacies']);

            $member = Member::create($memberData);

            foreach ($contributions as $contribution) {
                $member->contributions()->create($contribution);
            }

            foreach ($legacies as $legacy) {
                $member->legacies()->create(['content' => $legacy]);
            }
        }
    }
}
