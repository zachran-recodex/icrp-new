<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Library</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Library</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-4 md:w-3/4">
            <div class="w-full md:w-1/4">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search libraries..." icon="magnifying-glass" />
            </div>
            <div class="w-full md:w-1/4">
                <flux:select wire:model.live="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach($categoryOptions as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-full md:w-1/4">
                <flux:select wire:model.live="languageFilter">
                    <option value="">All Languages</option>
                    @foreach($languageOptions as $language)
                        <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </flux:select>
            </div>
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">
            Add Book
        </flux:button>
    </div>

    <div class="border border-zinc-200 bg-white rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200">
                <thead class="bg-zinc-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('title')">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
                                @if ($sortField === 'title')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon name="chevron-up" variant="mini" class="size-3" />
                                        @else
                                            <flux:icon name="chevron-down" variant="mini" class="size-3" />
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('author')">
                            <div class="flex items-center space-x-1">
                                <span>Author</span>
                                @if ($sortField === 'author')
                                    <span>
                                        @if ($sortDirection === 'asc')
                                            <flux:icon name="chevron-up" variant="mini" class="size-3" />
                                        @else
                                            <flux:icon name="chevron-down" variant="mini" class="size-3" />
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Language
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Year
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($libraries as $library)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900">
                                <div class="flex items-center">
                                    @if ($library->image && Storage::disk('public')->exists($library->image))
                                        <img src="{{ Storage::url($library->image) }}" alt="{{ $library->title }}" class="w-10 h-14 object-cover rounded mr-3">
                                    @else
                                        <div class="w-10 h-14 flex items-center justify-center bg-zinc-100 rounded mr-3">
                                            <flux:icon name="book-open" variant="mini" class="text-zinc-400" />
                                        </div>
                                    @endif
                                    <div class="truncate max-w-xs">{{ $library->title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $library->author }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                <flux:badge>{{ $library->category }}</flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $library->language }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $library->publication_year ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $library->id }})" class="text-blue-800! bg-blue-400/20!" />
                                    <flux:button size="sm" icon="trash" wire:click="confirmDelete({{ $library->id }})" class="text-red-800! bg-red-400/20!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 text-center" colspan="6">
                                No books found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-zinc-200">
            {{ $libraries->links() }}
        </div>
    </div>

    <!-- Library Form Modal -->
    <flux:modal name="libraryModal" class="min-w-sm md:min-w-2xl lg:min-w-3xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $libraryId ? 'Edit Book' : 'Add Book' }}</flux:heading>

            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Tabs for different sections -->
                <div x-data="{ activeTab: 'basic' }">
                    <div class="border-b border-zinc-200 mb-4">
                        <div class="flex -mb-px">
                            <button
                                type="button"
                                class="px-4 py-2 font-medium text-sm"
                                :class="activeTab === 'basic' ? 'border-b-2 border-accent text-accent' : 'text-zinc-500 hover:text-zinc-700'"
                                @click="activeTab = 'basic'"
                            >
                                Basic Information
                            </button>
                            <button
                                type="button"
                                class="px-4 py-2 font-medium text-sm"
                                :class="activeTab === 'details' ? 'border-b-2 border-accent text-accent' : 'text-zinc-500 hover:text-zinc-700'"
                                @click="activeTab = 'details'"
                            >
                                Additional Details
                            </button>
                            <button
                                type="button"
                                class="px-4 py-2 font-medium text-sm"
                                :class="activeTab === 'reviews' ? 'border-b-2 border-accent text-accent' : 'text-zinc-500 hover:text-zinc-700'"
                                @click="activeTab = 'reviews'"
                            >
                                Reviews
                            </button>
                        </div>
                    </div>

                    <!-- Basic Information Tab -->
                    <div x-show="activeTab === 'basic'" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:field class="md:col-span-2">
                                <flux:label for="title">Title</flux:label>
                                <flux:input id="title" wire:model="title" placeholder="Enter book title" />
                                <flux:error name="title" />
                            </flux:field>

                            <flux:field class="md:col-span-2">
                                <flux:label for="author">Author</flux:label>
                                <flux:input id="author" wire:model="author" placeholder="Enter author name" />
                                <flux:error name="author" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="category">Category</flux:label>
                                <flux:select id="category" wire:model="category">
                                    <option value="">Select Category</option>
                                    @foreach($categoryOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="category" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="language">Language</flux:label>
                                <flux:select id="language" wire:model="language">
                                    <option value="">Select Language</option>
                                    @foreach($languageOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="language" />
                            </flux:field>
                        </div>

                        <flux:field>
                            <flux:label for="description">Description</flux:label>
                            <flux:textarea id="description" wire:model="description" rows="5" placeholder="Enter book description" />
                            <flux:error name="description" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Cover Image</flux:label>

                            @if ($image && !$newImage && Storage::disk('public')->exists($image))
                                <div class="mb-4">
                                    <flux:text class="text-sm mb-2">Current Cover:</flux:text>
                                    <img src="{{ Storage::url($image) }}" alt="Current book cover" class="max-w-xs h-auto rounded shadow-md">
                                </div>
                            @endif

                            <flux:input type="file" wire:model="newImage" accept="image/*" />
                            <flux:description>The image must not be larger than 2MB.</flux:description>
                            <flux:error name="newImage" />

                            @if ($newImage)
                                <div class="mt-4">
                                    <flux:text class="text-sm mb-2">Cover Preview:</flux:text>
                                    <img src="{{ $newImage->temporaryUrl() }}" alt="New book cover" class="max-w-xs h-auto rounded shadow-md">
                                </div>
                            @endif
                        </flux:field>
                    </div>

                    <!-- Additional Details Tab -->
                    <div x-show="activeTab === 'details'" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:field>
                                <flux:label for="publisher">Publisher</flux:label>
                                <flux:input id="publisher" wire:model="publisher" placeholder="Enter publisher name" />
                                <flux:error name="publisher" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="publication_year">Publication Year</flux:label>
                                <flux:input id="publication_year" wire:model="publication_year" type="number" min="1800" max="{{ date('Y') + 1 }}" />
                                <flux:error name="publication_year" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="isbn">ISBN</flux:label>
                                <flux:input id="isbn" wire:model="isbn" placeholder="Enter ISBN number" />
                                <flux:error name="isbn" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="page_count">Page Count</flux:label>
                                <flux:input id="page_count" wire:model="page_count" type="number" min="1" />
                                <flux:error name="page_count" />
                            </flux:field>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div x-show="activeTab === 'reviews'" class="space-y-4">
                        <div class="mb-4 border-b pb-4">
                            <flux:heading size="sm">Add New Review</flux:heading>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <flux:field>
                                    <flux:label for="new_review_reviewer">Reviewer Name</flux:label>
                                    <flux:input id="new_review_reviewer" wire:model="newReview.reviewer" placeholder="Enter reviewer name" />
                                    <flux:error name="newReview.reviewer" />
                                </flux:field>
                                <flux:field>
                                    <flux:label for="new_review_content">Review Content</flux:label>
                                    <flux:textarea id="new_review_content" wire:model="newReview.review" rows="3" placeholder="Enter review content" />
                                    <flux:error name="newReview.review" />
                                </flux:field>
                            </div>
                            <div class="mt-3 flex justify-end">
                                <flux:button variant="filled" icon="plus" wire:click="addReview" type="button">
                                    Add Review
                                </flux:button>
                            </div>
                        </div>

                        <!-- List of reviews -->
                        <div class="space-y-4">
                            <flux:heading size="sm">Reviews</flux:heading>
                            @if (count($reviews) === 0)
                                <flux:text class="text-sm text-zinc-500 italic">No reviews added yet.</flux:text>
                            @else
                                @foreach ($reviews as $index => $review)
                                    <div class="border rounded-lg p-4 bg-zinc-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <flux:heading size="sm" class="mb-1">{{ $review['reviewer'] }}</flux:heading>
                                                <flux:text>{{ $review['review'] }}</flux:text>
                                            </div>
                                            <flux:button size="xs" variant="ghost" wire:click="confirmDeleteReview({{ $index }})" class="text-red-600">
                                                <flux:icon name="trash" variant="mini" />
                                            </flux:button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-x-2 pt-4 border-t">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit">{{ $libraryId ? 'Update' : 'Create' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Library Modal -->
    <flux:modal name="deleteLibraryModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Book</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to delete this book?</p>
                <p>This action will also delete all associated reviews and comments.</p>
                <p>This action cannot be undone.</p>
            </flux:text>

            <div class="flex justify-end gap-x-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="delete" type="button">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Delete Review Modal -->
    <flux:modal name="deleteReviewModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Review</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to remove this review?</p>
            </flux:text>

            <div class="flex justify-end gap-x-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="deleteReview" type="button">Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
