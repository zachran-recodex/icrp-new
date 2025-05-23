<?php

namespace App\Livewire\Dashboard;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManagePrograms extends Component
{
    use WithPagination, WithFileUploads;

    public $programId;
    public $title;
    public $description;
    public $image;
    public $newImage;

    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'newImage' => $this->programId
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    protected function messages()
    {
        return [
            'newImage.required' => 'The program image is required.',
            'description.required' => 'The program description is required.',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetFormFields();
        $this->modal('programModal')->show();
    }

    public function edit($programId)
    {
        $program = Program::findOrFail($programId);

        $this->resetValidation();
        $this->resetFormFields();

        $this->programId = $program->id;
        $this->title = $program->title;
        $this->description = $program->description;
        $this->image = $program->image;

        $this->modal('programModal')->show();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->programId) {
                $this->updateProgram();
            } else {
                $this->createProgram();
            }

            DB::commit();
            flash()->success('Program ' . ($this->programId ? 'updated' : 'created') . ' successfully.');

            $this->resetFormFields();
            $this->modal('programModal')->close();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save program: ' . $e->getMessage());
        }
    }

    private function createProgram()
    {
        // Handle image upload
        $imagePath = $this->storeImage();

        // Create program
        Program::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
        ]);
    }

    private function updateProgram()
    {
        $program = Program::findOrFail($this->programId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($program->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        // Update program
        $program->update($data);
    }

    private function storeImage()
    {
        return $this->newImage->store('programs', 'public');
    }

    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    private function resetFormFields()
    {
        $this->reset([
            'programId',
            'title',
            'description',
            'image',
            'newImage',
        ]);
    }

    public function confirmDelete($programId)
    {
        $this->programId = $programId;
        $this->modal('deleteProgramModal')->show();
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            $program = Program::findOrFail($this->programId);

            // Delete image
            $this->deleteOldImage($program->image);

            // Delete program
            $program->delete();

            DB::commit();
            flash()->success('Program deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to delete program: ' . $e->getMessage());
        }

        $this->modal('deleteProgramModal')->close();
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

    public function render()
    {
        $programs = Program::query()
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-programs', [
            'programs' => $programs,
        ]);
    }
}
