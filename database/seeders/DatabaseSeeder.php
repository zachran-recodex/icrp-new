<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersRolesAndPermissionsSeeder::class,
            HeroSeeder::class,
            FounderSeeder::class,
            MemberSeeder::class,
            ArticleCategorySeeder::class,
            ArticleSeeder::class,
            LibrarySeeder::class,
            EventSeeder::class,
            ProgramSeeder::class,
            AdvocacySeeder::class,
        ]);
    }
}
