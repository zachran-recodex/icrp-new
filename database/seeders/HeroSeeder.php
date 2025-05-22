<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroes = [
            [
                'title' => 'Membangun Jembatan Perdamaian',
                'subtitle' => 'Menyatukan keberagaman agama untuk Indonesia yang damai dan toleran',
                'image' => 'hero-peace.jpg'
            ],
        ];

        foreach ($heroes as $hero) {
            Hero::create($hero);
        }
    }
}
