<?php

namespace App\Livewire\Dashboard;

use App\Models\Library;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageLibraries extends Component
{
    use WithPagination, WithFileUploads;

    // Primary form properties
    public $libraryId;
    public $title;
    public $author;
    public $description;
    public $publisher;
    public $publication_year;
    public $isbn;
    public $category;
    public $page_count;
    public $language;
    public $image;
    public $newImage;

    // Reviews management
    public $reviews = [];
    public $newReview = ['reviewer' => '', 'review' => ''];
    public $reviewToDelete;

    // Listing and filtering properties
    public $search = '';
    public $categoryFilter = '';
    public $languageFilter = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';

    // Available options for dropdowns
    public $categoryOptions = [
        'Religion',
        'Philosophy',
        'Peace Studies',
        'Social Science',
        'History',
        'Politics',
        'Education',
        'Culture',
        'Other'
    ];

    public $languageOptions = [
        'English',
        'Indonesian',
        'Arabic',
        'Sundanese',
        'Javanese',
        'Other'
    ];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'isbn' => [
                'nullable',
                'string',
                'max:20',
                $this->libraryId
                    ? 'unique:libraries,isbn,' . $this->libraryId
                    : 'unique:libraries,isbn'
            ],
            'category' => 'required|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'required|string|max:255',
            'newImage' => $this->libraryId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validate reviews
            'reviews.*.reviewer' => 'required|string|max:255',
            'reviews.*.review' => 'required|string',

            // Validate new review
            'newReview.reviewer' => 'required_with:newReview.review|string|max:255',
            'newReview.review' => 'required_with:newReview.reviewer|string',
        ];
    }

    protected function messages()
    {
        return [
            'newImage.required' => 'The book cover image is required.',
            'isbn.unique' => 'The ISBN has already been taken.',
            'publication_year.max' => 'The publication year cannot be in the future.',
            'newReview.reviewer.required_with' => 'The reviewer name is required when adding a review.',
            'newReview.review.required_with' => 'The review content is required when adding a reviewer.',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->reviews = [];

        $this->modal('libraryModal')->show();
    }

    public function edit($libraryId)
    {
        $library = Library::with(['reviews'])->findOrFail($libraryId);

        $this->resetValidation();
        $this->resetForm();

        $this->libraryId = $library->id;
        $this->title = $library->title;
        $this->author = $library->author;
        $this->description = $library->description;
        $this->publisher = $library->publisher;
        $this->publication_year = $library->publication_year;
        $this->isbn = $library->isbn;
        $this->category = $library->category;
        $this->page_count = $library->page_count;
        $this->language = $library->language;
        $this->image = $library->image;

        // Load reviews
        $this->reviews = $library->reviews->map(function($item) {
            return [
                'id' => $item->id,
                'reviewer' => $item->reviewer,
                'review' => $item->review,
            ];
        })->toArray();

        $this->modal('libraryModal')->show();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->libraryId) {
                $this->updateLibrary();
            } else {
                $this->createLibrary();
            }

            DB::commit();
            flash()->success('Library ' . ($this->libraryId ? 'updated' : 'created') . ' successfully.');

            $this->resetForm();
            $this->modal('libraryModal')->close();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save library: ' . $e->getMessage());
        }
    }

    private function createLibrary()
    {
        // Handle image upload
        $imagePath = $this->storeImage();

        // Create library
        $library = Library::create([
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'publisher' => $this->publisher,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'category' => $this->category,
            'page_count' => $this->page_count,
            'language' => $this->language,
            'image' => $imagePath,
        ]);

        $this->handleReviews($library);
    }

    private function updateLibrary()
    {
        $library = Library::findOrFail($this->libraryId);

        $data = [
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'publisher' => $this->publisher,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'category' => $this->category,
            'page_count' => $this->page_count,
            'language' => $this->language,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($library->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        // Update library
        $library->update($data);

        // Refresh the model to ensure we have the latest data
        $library = $library->fresh();

        $this->handleReviews($library);
    }

    private function handleReviews(Library $library)
    {
        // Get existing review IDs
        $existingIds = $library->reviews()->pluck('id')->toArray();
        $keepIds = [];

        // Update existing and create new reviews
        foreach ($this->reviews as $review) {
            if (isset($review['id'])) {
                // Update existing
                $library->reviews()->where('id', $review['id'])->update([
                    'reviewer' => $review['reviewer'],
                    'review' => $review['review'],
                ]);
                $keepIds[] = $review['id'];
            } else {
                // Create new
                $library->reviews()->create([
                    'reviewer' => $review['reviewer'],
                    'review' => $review['review'],
                ]);
            }
        }

        // Delete removed reviews
        $deleteIds = array_diff($existingIds, $keepIds);
        if (!empty($deleteIds)) {
            $library->reviews()->whereIn('id', $deleteIds)->delete();
        }

        // Add new review if provided
        if (!empty($this->newReview['reviewer']) && !empty($this->newReview['review'])) {
            $library->reviews()->create([
                'reviewer' => $this->newReview['reviewer'],
                'review' => $this->newReview['review'],
            ]);
        }
    }

    private function storeImage()
    {
        return $this->newImage->store('libraries', 'public');
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
            'libraryId',
            'title',
            'author',
            'description',
            'publisher',
            'publication_year',
            'isbn',
            'category',
            'page_count',
            'language',
            'image',
            'newImage',
            'reviews',
            'reviewToDelete',
        ]);

        $this->newReview = ['reviewer' => '', 'review' => ''];
    }

    public function addReview()
    {
        if (empty($this->newReview['reviewer']) || empty($this->newReview['review'])) {
            return;
        }

        $this->validate([
            'newReview.reviewer' => 'required|string|max:255',
            'newReview.review' => 'required|string',
        ]);

        $this->reviews[] = $this->newReview;
        $this->newReview = ['reviewer' => '', 'review' => ''];
    }

    public function confirmDeleteReview($index)
    {
        $this->reviewToDelete = $index;
        $this->modal('deleteReviewModal')->show();
    }

    public function deleteReview()
    {
        if (isset($this->reviewToDelete)) {
            unset($this->reviews[$this->reviewToDelete]);
            $this->reviews = array_values($this->reviews);
            $this->reviewToDelete = null;
        }

        $this->modal('deleteReviewModal')->close();
    }

    public function confirmDelete($libraryId)
    {
        $this->libraryId = $libraryId;
        $this->modal('deleteLibraryModal')->show();
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            $library = Library::findOrFail($this->libraryId);

            // Delete related models
            $library->reviews()->delete();
            $library->comments()->delete();

            // Delete image
            $this->deleteOldImage($library->image);

            // Delete library
            $library->delete();

            DB::commit();
            flash()->success('Library deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to delete library: ' . $e->getMessage());
        }

        $this->modal('deleteLibraryModal')->close();
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

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatedLanguageFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $libraries = Library::with(['reviews'])
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('author', 'like', '%' . $this->search . '%')
                      ->orWhere('publisher', 'like', '%' . $this->search . '%')
                      ->orWhere('isbn', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                return $query->where('category', $this->categoryFilter);
            })
            ->when($this->languageFilter, function ($query) {
                return $query->where('language', $this->languageFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-libraries', [
            'libraries' => $libraries,
        ]);
    }
}
