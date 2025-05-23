<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('beranda');

    Route::get('/tentang-kami', 'tentang')->name('tentang');

    Route::get('/pendiri', 'pendiri')->name('pendiri');
    Route::get('/pendiri/{slug}', 'pendiriDetail')->name('pendiri.detail');

    Route::get('/pengurus', 'pengurus')->name('pengurus');
    Route::get('/pengurus/{slug}', 'pengurusDetail')->name('pengurus.detail');

    Route::get('/kontak', 'kontak')->name('kontak');

    Route::get('/sahabat', 'sahabat')->name('sahabat');

    Route::get('/jaringan', 'jaringan')->name('jaringan');

    Route::get('/berita-artikel', 'berita')->name('berita');
    Route::get('/berita-artikel/{slug}', 'beritaDetail')->name('berita.detail');

    Route::get('/pustaka', 'pustaka')->name('pustaka');
    Route::get('/pustaka/{slug}', 'pustakaDetail')->name('pustaka.detail');

    Route::get('/advokasi', 'advokasi')->name('advokasi');
    Route::get('/advokasi/{slug}', 'advokasiDetail')->name('advokasi.detail');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/hero', App\Livewire\Dashboard\ManageHero::class)->name('hero');
        Route::get('/article-categories', App\Livewire\Dashboard\ManageArticleCategories::class)->name('article-categories');
        Route::get('/articles', App\Livewire\Dashboard\ManageArticles::class)->name('articles');
        Route::get('/events', App\Livewire\Dashboard\ManageEvents::class)->name('events');
        Route::get('/founders', App\Livewire\Dashboard\ManageFounders::class)->name('founders');
        Route::get('/members', App\Livewire\Dashboard\ManageMembers::class)->name('members');
        Route::get('/libraries', App\Livewire\Dashboard\ManageLibraries::class)->name('libraries');
        Route::get('/programs', App\Livewire\Dashboard\ManagePrograms::class)->name('programs');
        Route::get('/call-to-action', App\Livewire\Dashboard\ManageCallToAction::class)->name('call-to-action');
        Route::get('/advocacies', App\Livewire\Dashboard\ManageAdvocacies::class)->name('advocacies');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
});

require __DIR__.'/auth.php';
