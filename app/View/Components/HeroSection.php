<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroSection extends Component
{
    public string $title;
    public string $image;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $image)
    {
        $this->title = $title;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero-section');
    }
}
