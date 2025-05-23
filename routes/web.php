<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HeroController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
