<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Article Categories</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Article Categories</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="flex items-center justify-between">
        <div class="w-1/3">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search categories..." icon="magnifying-glass" />
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">
            Add Category
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Articles Count
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900">
                                {{ $category->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $category->articles->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $category->id }})" class="text-blue-800! bg-blue-400/20!" />
                                    <flux:button size="sm" icon="trash" wire:click="confirmDelete({{ $category->id }})" class="text-red-800! bg-red-400/20!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 text-center" colspan="3">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-zinc-200">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Category Form Modal -->
    <flux:modal name="formModal" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $categoryId ? 'Edit Category' : 'Add Category' }}</flux:heading>

            <form wire:submit.prevent="save" class="space-y-4">
                <flux:field>
                    <flux:label for="title">Title</flux:label>
                    <flux:input id="title" wire:model="title" placeholder="Enter category title" />
                    <flux:error name="title" />
                </flux:field>

                <div class="flex justify-end gap-x-2">

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit">{{ $categoryId ? 'Update' : 'Create' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="deleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Category</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to delete this category?</p>
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
</div>
