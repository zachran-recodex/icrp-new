<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Advocacies</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Advocacies</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="w-full md:w-1/3">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search advocacies..." icon="magnifying-glass" />
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">
            Add Advocacy
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            <div class="flex items-center space-x-1">
                                <span>Date</span>
                                @if ($sortField === 'created_at')
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
                            Content Preview
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($advocacies as $advocacy)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900">
                                <div class="flex items-center">
                                    @if ($advocacy->image && Storage::disk('public')->exists($advocacy->image))
                                        <img src="{{ Storage::url($advocacy->image) }}" alt="{{ $advocacy->title }}" class="w-10 h-10 object-cover rounded-lg mr-3">
                                    @else
                                        <div class="w-10 h-10 flex items-center justify-center bg-zinc-100 rounded-lg mr-3">
                                            <flux:icon name="document-text" variant="mini" class="text-zinc-400" />
                                        </div>
                                    @endif
                                    <div class="truncate max-w-xs">{{ $advocacy->title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $advocacy->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-500">
                                <div class="truncate max-w-md">{{ Str::limit(strip_tags($advocacy->content), 100) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $advocacy->id }})" class="text-blue-800! bg-blue-400/20!" />
                                    <flux:button size="sm" icon="trash" wire:click="confirmDelete({{ $advocacy->id }})" class="text-red-800! bg-red-400/20!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 text-center" colspan="4">
                                No advocacies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-zinc-200">
            {{ $advocacies->links() }}
        </div>
    </div>

    <!-- Advocacy Form Modal -->
    <flux:modal name="formModal" class="min-w-sm md:min-w-2xl lg:min-w-3xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $advocacyId ? 'Edit Advocacy' : 'Add Advocacy' }}</flux:heading>

            <form wire:submit.prevent="save" class="space-y-4">
                <flux:field>
                    <flux:label for="title">Title</flux:label>
                    <flux:input id="title" wire:model="title" placeholder="Enter advocacy title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label for="content">Content</flux:label>
                    <flux:textarea id="content" wire:model="content" rows="6" placeholder="Enter advocacy content" />
                    <flux:error name="content" />
                </flux:field>

                <flux:field>
                    <flux:label>Image</flux:label>

                    @if ($image && !$newImage && Storage::disk('public')->exists($image))
                        <div class="mb-4">
                            <flux:text class="text-sm mb-2">Current Image:</flux:text>
                            <img src="{{ Storage::url($image) }}" alt="Current advocacy image" class="max-w-xs h-auto rounded-lg shadow-md">
                        </div>
                    @endif

                    <flux:input type="file" wire:model="newImage" accept="image/*" />
                    <flux:description>The image must not be larger than 2MB.</flux:description>
                    <flux:error name="newImage" />

                    @if ($newImage)
                        <div class="mt-4">
                            <flux:text class="text-sm mb-2">Image Preview:</flux:text>
                            <img src="{{ $newImage->temporaryUrl() }}" alt="New advocacy image" class="max-w-xs h-auto rounded-lg shadow-md">
                        </div>
                    @endif
                </flux:field>

                <div class="flex justify-end gap-x-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit">{{ $advocacyId ? 'Update' : 'Create' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="deleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Advocacy</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to delete this advocacy?</p>
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
