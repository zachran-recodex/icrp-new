<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Dialog Antar Agama',
            'Perdamaian',
            'Toleransi',
            'Pendidikan',
            'Kegiatan ICRP',
            'Opini',
            'Penelitian',
            'Berita'
        ];

        foreach ($categories as $category) {
            ArticleCategory::create(['title' => $category]);
        }
    }
}
