<?php

namespace App\Livewire\Dashboard;

use App\Models\Hero;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ManageHero extends Component
{
    use WithFileUploads;

    public $heroId;
    public $title;
    public $subtitle;
    public $image;
    public $newImage;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'newImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // 1MB Max
        ];
    }

    public function mount()
    {
        // Get the first hero or create a new one if none exists
        $hero = Hero::first() ?? new Hero();

        $this->heroId = $hero->id;
        $this->title = $hero->title;
        $this->subtitle = $hero->subtitle;
        $this->image = $hero->image;
    }

    public function save()
    {
        $this->validate();

        $hero = $this->heroId ? Hero::find($this->heroId) : new Hero();

        $hero->title = $this->title;
        $hero->subtitle = $this->subtitle;

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image if it exists
            if ($hero->image && Storage::disk('public')->exists($hero->image)) {
                Storage::disk('public')->delete($hero->image);
            }

            // Store the new image
            $imagePath = $this->newImage->store('heroes', 'public');
            $hero->image = $imagePath;
        }

        $hero->save();

        flash()->success('Hero section updated successfully.');
        $this->reset('newImage');
    }

    public function render()
    {
        return view('livewire.dashboard.manage-hero');
    }
}
