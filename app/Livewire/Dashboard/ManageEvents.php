<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ManageEvents extends Component
{
    use WithPagination, WithFileUploads;

    // Form properties
    public $eventId;
    public $title;
    public $description;
    public $date;
    public $time;
    public $location;
    public $image;
    public $newImage;

    // List filtering and sorting properties
    public $search = '';
    public $timeFilter = ''; // all, upcoming, past
    public $sortField = 'date';
    public $sortDirection = 'desc';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|date_format:Y-m-d',
            'time' => ['required', 'date_format:H:i'],
            'location' => 'required|string|max:255',
            'newImage' => $this->eventId
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    protected function messages()
    {
        return [
            'time.date_format' => 'The time field must be in the format HH:MM.',
            'newImage.required' => 'An image is required for new events.',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->modal('formModal')->show();
    }

    public function edit($eventId)
    {
        $event = Event::findOrFail($eventId);

        $this->resetValidation();
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->date = $event->date->format('Y-m-d');
        $this->time = $event->time->format('H:i');
        $this->location = $event->location;
        $this->image = $event->image;

        $this->modal('formModal')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->eventId) {
            $this->updateEvent();
        } else {
            $this->createEvent();
        }

        $this->resetForm();
        $this->modal('formModal')->close();
        $this->resetPage();
    }

    private function createEvent()
    {
        $imagePath = $this->storeImage();

        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'image' => $imagePath,
        ]);

        flash()->success('Event created successfully.');
    }

    private function updateEvent()
    {
        $event = Event::findOrFail($this->eventId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($event->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        $event->update($data);

        flash()->success('Event updated successfully.');
    }

    private function storeImage()
    {
        return $this->newImage->store('events', 'public');
    }

    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Reset all form fields
     *
     * @return void
     */
    private function resetForm()
    {
        $this->reset([
            'eventId',
            'title',
            'description',
            'date',
            'time',
            'location',
            'image',
            'newImage'
        ]);
    }

    public function confirmDelete($eventId)
    {
        $event = Event::findOrFail($eventId);
        $this->eventId = $event->id;
        $this->modal('deleteModal')->show();
    }

    public function delete()
    {
        $event = Event::findOrFail($this->eventId);

        // Delete the event image
        $this->deleteOldImage($event->image);

        // Delete the event record
        $event->delete();

        flash()->success('Event deleted successfully.');
        $this->modal('deleteModal')->close();
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTimeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $events = Event::query()
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->timeFilter === 'upcoming', function ($query) {
                return $query->upcoming();
            })
            ->when($this->timeFilter === 'past', function ($query) {
                return $query->past();
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-events', [
            'events' => $events,
        ]);
    }
}
