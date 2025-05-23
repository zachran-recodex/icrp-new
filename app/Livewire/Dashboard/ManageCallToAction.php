<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\CallToAction;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ManageCallToAction extends Component
{
    use WithFileUploads;

    public $callToActionId;
    public $title;
    public $subtitle;
    public $button_text;
    public $image;
    public $newImage;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'button_text' => 'required|string|max:50',
            'newImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // 1MB Max
        ];
    }

    public function mount()
    {
        // Get the first call to action or create a new one if none exists
        $callToAction = CallToAction::first() ?? new CallToAction();

        $this->callToActionId = $callToAction->id;
        $this->title = $callToAction->title;
        $this->subtitle = $callToAction->subtitle;
        $this->button_text = $callToAction->button_text;
        $this->image = $callToAction->image;
    }

    public function save()
    {
        $this->validate();

        $callToAction = $this->callToActionId ? CallToAction::find($this->callToActionId) : new CallToAction();

        $callToAction->title = $this->title;
        $callToAction->subtitle = $this->subtitle;
        $callToAction->button_text = $this->button_text;

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image if it exists
            if ($callToAction->image && Storage::disk('public')->exists($callToAction->image)) {
                Storage::disk('public')->delete($callToAction->image);
            }

            // Store the new image
            $imagePath = $this->newImage->store('call-to-actions', 'public');
            $callToAction->image = $imagePath;
        }

        $callToAction->save();

        flash()->success('Call to action updated successfully.');
        $this->reset('newImage');
    }

    public function render()
    {
        return view('livewire.dashboard.manage-call-to-action');
    }
}
