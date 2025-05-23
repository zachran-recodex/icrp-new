<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Event;
use App\Models\Member;
use App\Models\Article;
use App\Models\Library;
use App\Models\Founder;
use App\Models\Program;
use App\Models\Advocacy;
use App\Models\CallToAction;
use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $heroSection = Hero::first();
        $articles = Article::with('category')->latest()->take(6)->get();
        $featuredArticle = Article::with('category')->latest()->first();
        $libraries = Library::latest()->take(3)->get();
        $events = Event::upcoming()->take(3)->get();
        $callToAction = CallToAction::first();
        $programs = Program::take(3)->get();

        return view('main.index', compact(
            'heroSection',
            'articles',
            'featuredArticle',
            'libraries',
            'events',
            'callToAction',
            'programs'
        ));
    }

    /**
     * Display the about page.
     */
    public function tentang(): View
    {
        $heroSection = Hero::where('title', 'Tentang Kami')->first() ?? Hero::first();
        $callToAction = CallToAction::first();
        $programs = Program::all();

        return view('main.tentang', compact(
            'heroSection',
            'callToAction',
            'programs'
        ));
    }

    /**
     * Display the founder page.
     */
    public function pendiri(): View
    {
        $heroSection = Hero::where('title', 'Pendiri ICRP')->first() ?? Hero::first();
        $founders = Founder::ordered()->get();
        $callToAction = CallToAction::first();

        return view('main.pendiri', compact(
            'heroSection',
            'founders',
            'callToAction'
        ));
    }

    /**
     * Display the founder detail page.
     */
    public function pendiriDetail(string $slug): View
    {
        $founder = Founder::with(['contributions', 'legacies'])->where('slug', $slug)->firstOrFail();
        $heroSection = Hero::where('title', 'Pendiri ICRP')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        return view('main.pendiri-detail', compact(
            'founder',
            'heroSection',
            'callToAction'
        ));
    }

    /**
     * Display the management page.
     */
    public function pengurus(): View
    {
        $heroSection = Hero::where('title', 'Pengurus ICRP')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        // Get members grouped by their roles
        $dewanDirectureExcecutive = Member::byDewan('Directure Excecutive')->ordered()->get();
        $dewanPengurus = Member::byDewan('Pengurus')->ordered()->get();
        $dewanKehormatan = Member::byDewan('Kehormatan')->ordered()->get();
        $dewanPembina = Member::byDewan('Pembina')->ordered()->get();
        $dewanPengawas = Member::byDewan('Pengawas')->ordered()->get();
        $dewanPengurusHarian = Member::byDewan('Pengurus Harian')->ordered()->get();

        return view('main.pengurus', compact(
            'heroSection',
            'callToAction',
            'dewanDirectureExcecutive',
            'dewanPengurus',
            'dewanKehormatan',
            'dewanPembina',
            'dewanPengawas',
            'dewanPengurusHarian'
        ));
    }

    /**
     * Display the management detail page.
     */
    public function pengurusDetail(string $slug): View
    {
        $management = Member::with(['contributions', 'legacies'])->where('slug', $slug)->firstOrFail();
        $heroSection = Hero::where('title', 'Pengurus ICRP')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        return view('main.pengurus-detail', compact(
            'management',
            'heroSection',
            'callToAction'
        ));
    }

    /**
     * Display the contact page.
     */
    public function kontak(): View
    {
        $heroSection = Hero::where('title', 'Kontak Kami')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        return view('main.kontak', compact(
            'heroSection',
            'callToAction'
        ));
    }

    /**
     * Display the friends page.
     */
    public function sahabat(): View
    {
        $heroSection = Hero::where('title', 'Sahabat ICRP')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        return view('main.sahabat', compact(
            'heroSection',
            'callToAction'
        ));
    }

    /**
     * Display the network page.
     */
    public function jaringan(): View
    {
        $heroSection = Hero::where('title', 'Jaringan')->first() ?? Hero::first();
        $callToAction = CallToAction::first();

        return view('main.jaringan', compact(
            'heroSection',
            'callToAction'
        ));
    }

    /**
     * Display the news page.
     */
    public function berita(): View
    {
        $heroSection = Hero::where('title', 'Berita & Artikel')->first() ?? Hero::first();
        $articles = Article::with('category')->latest()->take(9)->get();
        $featuredArticle = Article::with('category')->latest()->first();
        $callToAction = CallToAction::first();

        return view('main.berita', compact(
            'heroSection',
            'articles',
            'featuredArticle',
            'callToAction'
        ));
    }

    /**
     * Display the news detail page.
     */
    public function beritaDetail(string $slug): View
    {
        $article = Article::with('category')->where('slug', $slug)->firstOrFail();
        $heroSection = Hero::where('title', 'Berita & Artikel')->first() ?? Hero::first();
        $articles = Article::with('category')
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(6)
            ->get();
        $callToAction = CallToAction::first();

        return view('main.berita-detail', compact(
            'article',
            'heroSection',
            'articles',
            'callToAction'
        ));
    }

    /**
     * Display the library page.
     */
    public function pustaka(): View
    {
        $heroSection = Hero::where('title', 'Pustaka')->first() ?? Hero::first();
        $libraries = Library::latest()->get();
        $callToAction = CallToAction::first();

        return view('main.pustaka', compact(
            'heroSection',
            'libraries',
            'callToAction'
        ));
    }

    /**
     * Display the library detail page.
     */
    public function pustakaDetail(string $slug): View
    {
        $library = Library::with(['comments', 'reviews'])->where('slug', $slug)->firstOrFail();
        $heroSection = Hero::where('title', 'Pustaka')->first() ?? Hero::first();
        $libraries = Library::where('id', '!=', $library->id)->latest()->take(3)->get();
        $callToAction = CallToAction::first();

        return view('main.pustaka-detail', compact(
            'library',
            'heroSection',
            'libraries',
            'callToAction'
        ));
    }

    /**
     * Display the advocacy page.
     */
    public function advokasi(): View
    {
        $heroSection = Hero::where('title', 'Advokasi KBB')->first() ?? Hero::first();
        $advocacies = Advocacy::latest()->take(9)->get();
        $featuredAdvocacy = Advocacy::latest()->first();
        $callToAction = CallToAction::first();

        return view('main.advokasi', compact(
            'heroSection',
            'advocacies',
            'featuredAdvocacy',
            'callToAction'
        ));
    }

    /**
     * Display the advocacy detail page.
     */
    public function advokasiDetail(string $slug): View
    {
        $advocacy = Advocacy::where('slug', $slug)->firstOrFail();
        $heroSection = Hero::where('title', 'Advokasi KBB')->first() ?? Hero::first();
        $advocacies = Advocacy::where('id', '!=', $advocacy->id)->latest()->take(6)->get();
        $callToAction = CallToAction::first();

        return view('main.advokasi-detail', compact(
            'advocacy',
            'heroSection',
            'advocacies',
            'callToAction'
        ));
    }
}
