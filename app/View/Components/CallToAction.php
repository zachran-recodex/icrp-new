<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CallToAction extends Component
{
    public string $title;
    public string $subtitle;
    public string $image;
    public string $buttonText;
    public string $buttonLink;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $subtitle, string $image, string $buttonText, string $buttonLink)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->image = $image;
        $this->buttonText = $buttonText;
        $this->buttonLink = $buttonLink;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.call-to-action');
    }
}
