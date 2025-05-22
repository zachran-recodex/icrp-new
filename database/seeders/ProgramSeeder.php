<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Program Dialog Berkelanjutan',
                'description' => 'Program rutin yang mengadakan dialog antar tokoh agama setiap bulan untuk membahas isu-isu aktual yang berkaitan dengan kerukunan umat beragama.',
                'image' => 'program-ongoing-dialog.jpg'
            ],
            [
                'title' => 'Pendidikan Perdamaian untuk Sekolah',
                'description' => 'Program edukasi yang ditujukan untuk sekolah-sekolah guna menanamkan nilai-nilai toleransi dan perdamaian sejak dini kepada para siswa.',
                'image' => 'program-school-peace.jpg'
            ],
            [
                'title' => 'Mediasi Konflik Antar Agama',
                'description' => 'Program mediasi dan resolusi konflik yang melibatkan tokoh-tokoh agama untuk menyelesaikan sengketa atau ketegangan antar komunitas agama.',
                'image' => 'program-conflict-mediation.jpg'
            ],
            [
                'title' => 'Penelitian dan Publikasi',
                'description' => 'Program riset dan publikasi yang mengkaji berbagai aspek hubungan antar agama dan menerbitkan hasil penelitian untuk kepentingan akademik dan praktis.',
                'image' => 'program-research.jpg'
            ]
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
