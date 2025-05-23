<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ArticleCategory;

class ManageArticleCategories extends Component
{
    use WithPagination;

    public $categoryId;
    public $title;

    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    public function create()
    {
        $this->resetValidation();
        $this->reset('categoryId', 'title');
        $this->modal('formModal')->show();
    }

    public function edit(ArticleCategory $category)
    {
        $this->resetValidation();
        $this->categoryId = $category->id;
        $this->title = $category->title;
        $this->modal('formModal')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->categoryId) {
            // Update existing category
            $category = ArticleCategory::find($this->categoryId);
            $category->update([
                'title' => $this->title
            ]);
            flash()->success('Category updated successfully.');
        } else {
            // Create new category
            ArticleCategory::create([
                'title' => $this->title
            ]);
            flash()->success('Category created successfully.');
        }

        $this->reset('categoryId', 'title');
        $this->modal('formModal')->close();
        $this->resetPage();
    }

    public function confirmDelete(ArticleCategory $category)
    {
        $this->categoryId = $category->id;
        $this->modal('deleteModal')->show();
    }

    public function delete()
    {
        $category = ArticleCategory::findOrFail($this->categoryId);

        // Check if category has articles
        if ($category->articles()->count() > 0) {
            flash()->error('Cannot delete category with associated articles.');
            $this->modal('deleteModal')->close();
            return;
        }

        $category->delete();

        flash()->success('Category deleted successfully.');
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

    public function render()
    {
        $categories = ArticleCategory::query()
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.dashboard.manage-article-categories', [
            'categories' => $categories
        ]);
    }
}
