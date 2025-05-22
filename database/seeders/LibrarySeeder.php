<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Dialog Antar Agama: Teori dan Praktik',
                'author' => 'Dr. Djohan Effendi',
                'description' => 'Buku ini membahas secara mendalam tentang teori dan praktik dialog antar agama di Indonesia, dilengkapi dengan pengalaman empiris penulis.',
                'image' => 'book-dialog-theory.jpg',
                'publisher' => 'Mizan',
                'publication_year' => 2019,
                'isbn' => '978-602-441-123-4',
                'category' => 'Dialog Antar Agama',
                'page_count' => 324,
                'language' => 'Indonesia',
                'reviews' => [
                    [
                        'reviewer' => 'Prof. Dr. Komaruddin Hidayat',
                        'review' => 'Karya yang sangat penting untuk memahami dinamika dialog antar agama di Indonesia.'
                    ]
                ]
            ],
            [
                'title' => 'Pluralisme Agama di Indonesia',
                'author' => 'Prof. Dr. Azyumardi Azra',
                'description' => 'Analisis komprehensif tentang pluralisme agama dalam konteks Indonesia, dengan pendekatan historis dan sosiologis.',
                'image' => 'book-pluralism.jpg',
                'publisher' => 'Gramedia',
                'publication_year' => 2020,
                'isbn' => '978-602-03-456-7',
                'category' => 'Pluralisme',
                'page_count' => 456,
                'language' => 'Indonesia',
                'reviews' => [
                    [
                        'reviewer' => 'Dr. Ahmad Syafii Maarif',
                        'review' => 'Buku yang wajib dibaca untuk memahami keberagaman agama di Indonesia.'
                    ]
                ]
            ]
        ];

        foreach ($books as $bookData) {
            $reviews = $bookData['reviews'];
            unset($bookData['reviews']);

            $book = Library::create($bookData);

            foreach ($reviews as $review) {
                $book->reviews()->create($review);
            }
        }
    }
}
