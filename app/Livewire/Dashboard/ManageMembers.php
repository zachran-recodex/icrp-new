<?php

namespace App\Livewire\Dashboard;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageMembers extends Component
{
    use WithPagination, WithFileUploads;

    // Primary form properties
    public $memberId;
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
    public $position;
    public $dewan;

    // Contributions and legacies management
    public $contributions = [];
    public $legacies = [];
    public $newContribution = ['title' => '', 'description' => '', 'order' => 0];
    public $newLegacy = ['content' => ''];
    public $contributionToDelete;
    public $legacyToDelete;

    // Listing and filtering properties
    public $search = '';
    public $dewanFilter = '';
    public $sortField = 'order';
    public $sortDirection = 'asc';

    // Dewan options for select dropdown
    public $dewanOptions = [
        'Directure Excecutive',
        'Pengurus',
        'Kehormatan',
        'Pembina',
        'Pengawas',
        'Pengurus Harian'
    ];

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
            'position' => 'required|string|max:255',
            'dewan' => 'required|in:Directure Excecutive,Pengurus,Kehormatan,Pembina,Pengawas,Pengurus Harian',
            'newImage' => $this->memberId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

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
            'newImage.required' => 'The member photo is required.',
            'newLegacy.content.required_if' => 'At least one legacy entry is required.',
            'dewan.in' => 'The selected dewan is invalid.',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetForm();

        // Set default values
        $this->order = Member::max('order') + 1;
        $this->contributions = [];
        $this->legacies = [];

        $this->modal('memberModal')->show();
    }

    public function edit($memberId)
    {
        $member = Member::with(['contributions', 'legacies'])->findOrFail($memberId);

        $this->resetValidation();
        $this->resetForm();

        $this->memberId = $member->id;
        $this->name = $member->name;
        $this->nickname = $member->nickname;
        $this->birth_date = $member->birth_date->format('Y-m-d');
        $this->death_date = $member->death_date ? $member->death_date->format('Y-m-d') : null;
        $this->birth_place = $member->birth_place;
        $this->known_as = $member->known_as;
        $this->quote = $member->quote;
        $this->biography = $member->biography;
        $this->image = $member->image;
        $this->order = $member->order;
        $this->position = $member->position;
        $this->dewan = $member->dewan;

        // Load contributions and legacies
        $this->contributions = $member->contributions->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'order' => $item->order,
            ];
        })->toArray();

        $this->legacies = $member->legacies->map(function($item) {
            return [
                'id' => $item->id,
                'content' => $item->content,
            ];
        })->toArray();

        $this->modal('memberModal')->show();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->memberId) {
                $this->updateMember();
            } else {
                $this->createMember();
            }

            DB::commit();
            flash()->success('Member ' . ($this->memberId ? 'updated' : 'created') . ' successfully.');

            $this->resetForm();
            $this->modal('memberModal')->close();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save member: ' . $e->getMessage());
        }
    }

    private function createMember()
    {
        // Handle image upload
        $imagePath = $this->storeImage();

        // Create member
        $member = Member::create([
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
            'position' => $this->position,
            'dewan' => $this->dewan,
        ]);

        $this->handleContributions($member);
        $this->handleLegacies($member);
    }

    private function updateMember()
    {
        $member = Member::findOrFail($this->memberId);

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
            'position' => $this->position,
            'dewan' => $this->dewan,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($member->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        // Update member
        $member->update($data);

        // Refresh the model to ensure we have the latest data
        $member = $member->fresh();

        $this->handleContributions($member);
        $this->handleLegacies($member);
    }

    private function handleContributions(Member $member)
    {
        // Get existing contribution IDs
        $existingIds = $member->contributions()->pluck('id')->toArray();
        $keepIds = [];

        // Update existing and create new contributions
        foreach ($this->contributions as $contribution) {
            if (isset($contribution['id'])) {
                // Update existing
                $member->contributions()->where('id', $contribution['id'])->update([
                    'title' => $contribution['title'],
                    'description' => $contribution['description'],
                    'order' => $contribution['order'],
                ]);
                $keepIds[] = $contribution['id'];
            } else {
                // Create new
                $member->contributions()->create([
                    'title' => $contribution['title'],
                    'description' => $contribution['description'],
                    'order' => $contribution['order'],
                ]);
            }
        }

        // Delete removed contributions
        $deleteIds = array_diff($existingIds, $keepIds);
        if (!empty($deleteIds)) {
            $member->contributions()->whereIn('id', $deleteIds)->delete();
        }

        // Add new contribution if provided
        if (!empty($this->newContribution['title']) && !empty($this->newContribution['description'])) {
            $member->contributions()->create([
                'title' => $this->newContribution['title'],
                'description' => $this->newContribution['description'],
                'order' => $this->newContribution['order'],
            ]);
        }
    }

    private function handleLegacies(Member $member)
    {
        // Get existing legacy IDs
        $existingIds = $member->legacies()->pluck('id')->toArray();
        $keepIds = [];

        // Update existing and create new legacies
        foreach ($this->legacies as $legacy) {
            if (isset($legacy['id'])) {
                // Update existing
                $member->legacies()->where('id', $legacy['id'])->update([
                    'content' => $legacy['content'],
                ]);
                $keepIds[] = $legacy['id'];
            } else {
                // Create new
                $member->legacies()->create([
                    'content' => $legacy['content'],
                ]);
            }
        }

        // Delete removed legacies
        $deleteIds = array_diff($existingIds, $keepIds);
        if (!empty($deleteIds)) {
            $member->legacies()->whereIn('id', $deleteIds)->delete();
        }

        // Add new legacy if provided
        if (!empty($this->newLegacy['content'])) {
            $member->legacies()->create([
                'content' => $this->newLegacy['content'],
            ]);
        }
    }

    private function storeImage()
    {
        return $this->newImage->store('members', 'public');
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
            'memberId',
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
            'position',
            'dewan',
            'contributions',
            'legacies',
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

    public function confirmDeleteContribution($index)
    {
        $this->contributionToDelete = $index;
        $this->modal('deleteContributionModal')->show();
    }

    public function deleteContribution()
    {
        if (isset($this->contributionToDelete)) {
            unset($this->contributions[$this->contributionToDelete]);
            $this->contributions = array_values($this->contributions);
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

    public function confirmDeleteLegacy($index)
    {
        $this->legacyToDelete = $index;
        $this->modal('deleteLegacyModal')->show();
    }

    public function deleteLegacy()
    {
        if (isset($this->legacyToDelete)) {
            unset($this->legacies[$this->legacyToDelete]);
            $this->legacies = array_values($this->legacies);
            $this->legacyToDelete = null;
        }

        $this->modal('deleteLegacyModal')->close();
    }

    public function confirmDelete($memberId)
    {
        $this->memberId = $memberId;
        $this->modal('deleteMemberModal')->show();
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            $member = Member::findOrFail($this->memberId);

            // Delete related models
            $member->contributions()->delete();
            $member->legacies()->delete();

            // Delete image
            $this->deleteOldImage($member->image);

            // Delete member
            $member->delete();

            DB::commit();
            flash()->success('Member deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to delete member: ' . $e->getMessage());
        }

        $this->modal('deleteMemberModal')->close();
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

    public function updatedDewanFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $members = Member::with(['contributions', 'legacies'])
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nickname', 'like', '%' . $this->search . '%')
                      ->orWhere('known_as', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->dewanFilter, function ($query) {
                return $query->where('dewan', $this->dewanFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-members', [
            'members' => $members,
        ]);
    }
}
