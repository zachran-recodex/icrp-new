<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Konferensi Nasional Dialog Antar Agama 2025',
                'description' => 'Konferensi tahunan yang menghadirkan tokoh-tokoh agama dari berbagai daerah untuk membahas isu-isu terkini dalam hubungan antar umat beragama.',
                'image' => 'event-national-conference.jpg',
                'date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'time' => '08:00:00',
                'location' => 'Hotel Borobudur, Jakarta'
            ],
            [
                'title' => 'Workshop Pendidikan Perdamaian',
                'description' => 'Workshop untuk guru dan pendidik tentang bagaimana menanamkan nilai-nilai perdamaian dan toleransi dalam pendidikan.',
                'image' => 'event-peace-workshop.jpg',
                'date' => Carbon::now()->addWeeks(3)->format('Y-m-d'),
                'time' => '09:00:00',
                'location' => 'Universitas Indonesia, Depok'
            ],
            [
                'title' => 'Dialog Pemuda Lintas Agama',
                'description' => 'Acara dialog khusus untuk pemuda dari berbagai latar belakang agama untuk membangun jaringan dan kerjasama.',
                'image' => 'event-youth-dialog.jpg',
                'date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'time' => '14:00:00',
                'location' => 'Taman Ismail Marzuki, Jakarta'
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
