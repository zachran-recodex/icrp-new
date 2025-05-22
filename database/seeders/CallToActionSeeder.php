<?php

namespace Database\Seeders;

use App\Models\CallToAction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CallToActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $callToActions = [
            [
                'title' => 'Bergabunglah dengan Gerakan Perdamaian',
                'subtitle' => 'Jadilah bagian dari komunitas yang berkomitmen membangun perdamaian dan toleransi di Indonesia',
                'image' => 'cta-join-movement.jpg',
                'button_text' => 'Bergabung Sekarang'
            ],
        ];

        foreach ($callToActions as $cta) {
            CallToAction::create($cta);
        }
    }
}
