<?php

namespace App\Livewire\Dashboard;

use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Storage;

class ManageArticles extends Component
{
    use WithPagination, WithFileUploads;

    public $articleId;
    public $title;
    public $content;
    public $article_category_id;
    public $image;
    public $newImage;

    public $search = '';
    public $categoryFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'article_category_id' => 'required|exists:article_categories,id',
            'newImage' => $this->articleId ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024' : 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset('articleId', 'title', 'content', 'article_category_id', 'image', 'newImage');
        $this->modal('formModal')->show();
    }

    public function edit($articleId)
    {
        $article = Article::findOrFail($articleId);

        $this->resetValidation();
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->content = $article->content;
        $this->article_category_id = $article->article_category_id;
        $this->image = $article->image;
        $this->modal('formModal')->show();
    }

    public function save()
    {
        $this->validate();

        if ($this->articleId) {
            $this->updateArticle();
        } else {
            $this->createArticle();
        }

        $this->reset('articleId', 'title', 'content', 'article_category_id', 'newImage');
        $this->modal('formModal')->close();
        $this->resetPage();
    }

    private function createArticle()
    {
        // Handle image upload
        $imagePath = $this->storeImage();

        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'article_category_id' => $this->article_category_id,
            'image' => $imagePath,
            'slug' => Str::slug($this->title), // Let the HasSlug trait handle this
        ]);

        flash()->success('Article created successfully.');
    }

    private function updateArticle()
    {
        $article = Article::find($this->articleId);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'article_category_id' => $this->article_category_id,
        ];

        // Handle image upload if a new image is provided
        if ($this->newImage) {
            // Remove old image
            $this->deleteOldImage($article->image);

            // Store the new image
            $data['image'] = $this->storeImage();
        }

        $article->update($data);

        flash()->success('Article updated successfully.');
    }

    private function storeImage()
    {
        return $this->newImage->store('articles', 'public');
    }

    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    public function confirmDelete($articleId)
    {
        $article = Article::findOrFail($articleId);

        $this->articleId = $article->id;
        $this->modal('deleteModal')->show();
    }

    public function delete()
    {
        $article = Article::findOrFail($this->articleId);

        // Delete the image
        $this->deleteOldImage($article->image);

        // Delete the article
        $article->delete();

        flash()->success('Article deleted successfully.');
        $this->modal('deleteModal')->close();
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

    public function render()
    {
        $articles = Article::with('category')
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                return $query->where('article_category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $categories = ArticleCategory::orderBy('title')->get();

        return view('livewire.dashboard.manage-articles', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
