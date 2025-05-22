<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ArticleCategory::all();

        $articles = [
            [
                'title' => 'Membangun Toleransi di Era Digital',
                'content' => 'Di era digital ini, tantangan dalam membangun toleransi semakin kompleks. Media sosial dapat menjadi alat untuk menyebarkan kebencian, namun juga dapat digunakan untuk mempromosikan perdamaian dan toleransi...',
                'image' => 'article-digital-tolerance.jpg',
                'category' => 'Toleransi'
            ],
            [
                'title' => 'Dialog Lintas Agama: Kunci Perdamaian Indonesia',
                'content' => 'Indonesia sebagai negara dengan keberagaman agama yang tinggi memerlukan dialog yang berkelanjutan antar umat beragama. Dialog ini bukan hanya tentang saling mengenal, tetapi juga tentang membangun kerja sama...',
                'image' => 'article-interfaith-dialog.jpg',
                'category' => 'Dialog Antar Agama'
            ],
            [
                'title' => 'Peran Pemuda dalam Menjaga Kerukunan',
                'content' => 'Pemuda memiliki peran strategis dalam menjaga kerukunan antar umat beragama. Dengan semangat dan idealisme yang tinggi, pemuda dapat menjadi agen perubahan untuk menciptakan masyarakat yang lebih toleran...',
                'image' => 'article-youth-role.jpg',
                'category' => 'Pendidikan'
            ]
        ];

        foreach ($articles as $articleData) {
            $category = $categories->where('title', $articleData['category'])->first();
            unset($articleData['category']);

            Article::create(array_merge($articleData, [
                'article_category_id' => $category->id
            ]));
        }
    }
}
