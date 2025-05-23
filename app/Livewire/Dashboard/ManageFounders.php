<?php

namespace App\Livewire\Dashboard;

use App\Models\Founder;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageFounders extends Component
{
    use WithPagination, WithFileUploads;

    // Primary form properties
    public $founderId;
    public $name;
    public $nickname;
    public $birth_date;
    public $death_date;
    public $birth_place;
    public $known_as;
    public $quote;
    public $biography;
    public $image;
    public $newImage;
    public $order;

    // Contributions management
    public $contributions = [];
    public $legacies = [];
    public $newContribution = ['title' => '', 'description' => '', 'order' => 0];
    public $newLegacy = ['content' => ''];
    public $contributionToDelete;
    public $legacyToDelete;

    // Listing and filtering properties
    public $search = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'death_date' => 'nullable|date|after:birth_date',
            'birth_place' => 'required|string|max:255',
            'known_as' => 'required|string|max:255',
            'quote' => 'nullable|string',
            'biography' => 'required|string',
            'order' => 'required|integer|min:0',
            'newImage' => $this->founderId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validate contributions and legacies
            'contributions.*.title' => 'required|string|max:255',
            'contributions.*.description' => 'required|string',
            'contributions.*.order' => 'required|integer|min:0',
            'legacies.*.content' => 'required|string',

            // Validate new items
            'newContribution.title' => 'required_with:newContribution.description|string|max:255',
            'newContribution.description' => 'required_with:newContribution.title|string',
            'newContribution.order' => 'required|integer|min:0',
            'newLegacy.content' => 'required_if:legacies,[]|string',
        ];
    }

    protected function messages()
    {
        return [
            'death_date.after' => 'The date of death must be after the date of birth.',
            'newImage.required' => 'The founder photo is required.',
            'newLegacy.content.required_if' => 'At least one legacy entry is required.',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetForm();

        // Set default values
        $this->order = Founder::max('order') + 1;
        $this->contributions = [];
        $this->legacies = [];

        $this->modal('founderModal')->show();
    }

    public function edit($founderId)
    {
        $founder = Founder::with(['contributions', 'legacies'])->findOrFail($founderId);

        $this->resetValidation();
        $this->resetForm();

        $this->founderId = $founder->id;
        $this->name = $founder->name;
        $this->nickname = $founder->nickname;
        $this->birth_date = $founder->birth_date->format('Y-m-d');
        $this->death_date = $founder->death_date ? $founder->death_date->format('Y-m-d') : null;
        $this->birth_place = $founder->birth_place;
        $this->known_as = $founder->known_as;
        $this->quote = $founder->quote;
        $this->biography = $founder->biography;
        $this->image = $founder->image;
        $this->order = $founder->order;

        // Load contributions and legacies
        $this->contributions = $founder->contributions->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'order' => $item->order,
            ];
        })->toArray();

        $this->legacies = $founder->legacies->map(function($item) {
            return [
                'id' => $item->id,
                'content' => $item->content,
            ];
        })->toArray();

        $this->modal('founderModal')->show();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->founderId) {
                $this->updateFounder();
            } else {
                $this->createFounder();
            }

            DB::commit();
            flash()->success('Founder ' . ($this->founderId ? 'updated' : 'created') . ' successfully.');

            $this->resetForm();
            $this->modal('founderModal')->close();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save founder: ' . $e->getMessage());
        }
    }

    private function createFounder()
    {
        // Handle image upload
        $imagePath = $this->storeImage();

        // Create founder
        $founder = Founder::create([
            'name' => $this->name,
            'nickname' => $this->nickname,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'birth_place' => $this->birth_place,
            'known_as' => $this->known_as,
            'quote' => $this->quote,
            'biography' => $this->biography,
            'image' => $imagePath,
            'order' => $this->order,
        ]);

        // Make sure we have a single instance, not a collection
        $this->handleContributions($founder);
        $this->handleLegacies($founder);
    }

    private function updateFounder()
    {
        // Use findOrFail to get a single instance
        $founder = Founder::findOrFail($this->founderId);

        $data = [
            'name' => $this->name,
            'nickname' => $this->nickname,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'birth_place' => $this->birth_place,
            'known_as' => $this->known_as,
            'quote' => $this->quote,
            'biography' => $this->biography,
            'order' => $this->order,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($founder->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        // Update founder
        $founder->update($data);

        // We need to refresh the model after update to ensure we have the latest data
        $founder = $founder->fresh();

        // Now pass the single instance to these methods
        $this->handleContributions($founder);
        $this->handleLegacies($founder);
    }

    private function handleContributions(Founder $founder)
    {
        // Get existing contribution IDs
        $existingIds = $founder->contributions()->pluck('id')->toArray();
        $keepIds = [];

        // Update existing and create new contributions
        foreach ($this->contributions as $contribution) {
            if (isset($contribution['id'])) {
                // Update existing
                $founder->contributions()->where('id', $contribution['id'])->update([
                    'title' => $contribution['title'],
                    'description' => $contribution['description'],
                    'order' => $contribution['order'],
                ]);
                $keepIds[] = $contribution['id'];
            } else {
                // Create new
                $founder->contributions()->create([
                    'title' => $contribution['title'],
                    'description' => $contribution['description'],
                    'order' => $contribution['order'],
                ]);
            }
        }

        // Delete removed contributions
        $deleteIds = array_diff($existingIds, $keepIds);
        if (!empty($deleteIds)) {
            $founder->contributions()->whereIn('id', $deleteIds)->delete();
        }

        // Add new contribution if provided
        if (!empty($this->newContribution['title']) && !empty($this->newContribution['description'])) {
            $founder->contributions()->create([
                'title' => $this->newContribution['title'],
                'description' => $this->newContribution['description'],
                'order' => $this->newContribution['order'],
            ]);
        }
    }

    private function handleLegacies(Founder $founder)
    {
        // Get existing legacy IDs
        $existingIds = $founder->legacies()->pluck('id')->toArray();
        $keepIds = [];

        // Update existing and create new legacies
        foreach ($this->legacies as $legacy) {
            if (isset($legacy['id'])) {
                // Update existing
                $founder->legacies()->where('id', $legacy['id'])->update([
                    'content' => $legacy['content'],
                ]);
                $keepIds[] = $legacy['id'];
            } else {
                // Create new
                $founder->legacies()->create([
                    'content' => $legacy['content'],
                ]);
            }
        }

        // Delete removed legacies
        $deleteIds = array_diff($existingIds, $keepIds);
        if (!empty($deleteIds)) {
            $founder->legacies()->whereIn('id', $deleteIds)->delete();
        }

        // Add new legacy if provided
        if (!empty($this->newLegacy['content'])) {
            $founder->legacies()->create([
                'content' => $this->newLegacy['content'],
            ]);
        }
    }

    private function storeImage()
    {
        return $this->newImage->store('founders', 'public');
    }

    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    private function resetForm()
    {
        $this->reset([
            'founderId',
            'name',
            'nickname',
            'birth_date',
            'death_date',
            'birth_place',
            'known_as',
            'quote',
            'biography',
            'image',
            'newImage',
            'order',
            'contributions',
            'legacies',
            'newContribution',
            'newLegacy',
            'contributionToDelete',
            'legacyToDelete',
        ]);

        $this->newContribution = ['title' => '', 'description' => '', 'order' => 0];
        $this->newLegacy = ['content' => ''];
    }

    public function addContribution()
    {
        if (empty($this->newContribution['title']) || empty($this->newContribution['description'])) {
            return;
        }

        $this->validate([
            'newContribution.title' => 'required|string|max:255',
            'newContribution.description' => 'required|string',
            'newContribution.order' => 'required|integer|min:0',
        ]);

        $this->contributions[] = $this->newContribution;
        $this->newContribution = ['title' => '', 'description' => '', 'order' => count($this->contributions)];
    }

    public function removeContribution($index)
    {
        unset($this->contributions[$index]);
        $this->contributions = array_values($this->contributions);
    }

    public function confirmDeleteContribution($index)
    {
        $this->contributionToDelete = $index;
        $this->modal('deleteContributionModal')->show();
    }

    public function deleteContribution()
    {
        if (isset($this->contributionToDelete)) {
            $this->removeContribution($this->contributionToDelete);
            $this->contributionToDelete = null;
        }

        $this->modal('deleteContributionModal')->close();
    }

    public function addLegacy()
    {
        if (empty($this->newLegacy['content'])) {
            return;
        }

        $this->validate([
            'newLegacy.content' => 'required|string',
        ]);

        $this->legacies[] = $this->newLegacy;
        $this->newLegacy = ['content' => ''];
    }

    public function removeLegacy($index)
    {
        unset($this->legacies[$index]);
        $this->legacies = array_values($this->legacies);
    }

    public function confirmDeleteLegacy($index)
    {
        $this->legacyToDelete = $index;
        $this->modal('deleteLegacyModal')->show();
    }

    public function deleteLegacy()
    {
        if (isset($this->legacyToDelete)) {
            $this->removeLegacy($this->legacyToDelete);
            $this->legacyToDelete = null;
        }

        $this->modal('deleteLegacyModal')->close();
    }

    public function confirmDelete($founderId)
    {
        $this->founderId = $founderId;
        $this->modal('deleteFounderModal')->show();
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            $founder = Founder::findOrFail($this->founderId);

            // Delete related models
            $founder->contributions()->delete();
            $founder->legacies()->delete();

            // Delete image
            $this->deleteOldImage($founder->image);

            // Delete founder
            $founder->delete();

            DB::commit();
            flash()->success('Founder deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to delete founder: ' . $e->getMessage());
        }

        $this->modal('deleteFounderModal')->close();
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
        $founders = Founder::with(['contributions', 'legacies'])
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nickname', 'like', '%' . $this->search . '%')
                      ->orWhere('known_as', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-founders', [
            'founders' => $founders,
        ]);
    }
}
