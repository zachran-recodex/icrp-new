<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Events</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Events</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-4 md:w-2/3">
            <div class="w-full md:w-1/2">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search events..." icon="magnifying-glass" />
            </div>
            <div class="w-full md:w-1/2">
                <flux:select wire:model.live="timeFilter">
                    <option value="">All Events</option>
                    <option value="upcoming">Upcoming Events</option>
                    <option value="past">Past Events</option>
                </flux:select>
            </div>
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">
            Add Event
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('date')">
                            <div class="flex items-center space-x-1">
                                <span>Date</span>
                                @if ($sortField === 'date')
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
                            Location
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($events as $event)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900">
                                <div class="flex items-center">
                                    @if ($event->image && Storage::disk('public')->exists($event->image))
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-10 h-10 object-cover rounded-lg mr-3">
                                    @else
                                        <div class="w-10 h-10 flex items-center justify-center bg-zinc-100 rounded-lg mr-3">
                                            <flux:icon name="calendar-days" variant="mini" class="text-zinc-400" />
                                        </div>
                                    @endif
                                    <div class="truncate max-w-xs">{{ $event->title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                <div>{{ $event->formatted_date }}</div>
                                <div class="text-xs text-zinc-400">{{ $event->formatted_time }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $event->location }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($event->is_upcoming)
                                    <flux:badge color="green">Upcoming</flux:badge>
                                @else
                                    <flux:badge color="zinc">Past</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $event->id }})" class="text-blue-800! bg-blue-400/20!" />
                                    <flux:button size="sm" icon="trash" wire:click="confirmDelete({{ $event->id }})" class="text-red-800! bg-red-400/20!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 text-center" colspan="5">
                                No events found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-zinc-200">
            {{ $events->links() }}
        </div>
    </div>

    <!-- Event Form Modal -->
    <flux:modal name="formModal" class="min-w-sm md:min-w-2xl lg:min-w-3xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $eventId ? 'Edit Event' : 'Add Event' }}</flux:heading>

            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field class="md:col-span-2">
                        <flux:label>Title</flux:label>
                        <flux:input wire:model="title" placeholder="Enter event title" />
                        <flux:error name="title" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Date</flux:label>
                        <flux:input wire:model="date" type="date" />
                        <flux:error name="date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Time</flux:label>
                        <flux:input wire:model="time" type="time" />
                        <flux:error name="time" />
                    </flux:field>

                    <flux:field class="md:col-span-2">
                        <flux:label>Location</flux:label>
                        <flux:input wire:model="location" placeholder="Enter event location" />
                        <flux:error name="location" />
                    </flux:field>

                    <flux:field class="md:col-span-2">
                        <flux:label>Description</flux:label>
                        <flux:textarea wire:model="description" placeholder="Enter event description" />
                        <flux:error name="description" />
                    </flux:field>

                    <flux:field class="md:col-span-2">
                        <flux:label>Image</flux:label>

                        @if ($image && !$newImage && Storage::disk('public')->exists($image))
                            <div class="mb-4">
                                <flux:text class="text-sm mb-2">Current Image:</flux:text>
                                <img src="{{ Storage::url($image) }}" alt="Current event image" class="max-w-xs h-auto rounded-lg shadow-md">
                            </div>
                        @endif

                        <flux:input type="file" wire:model="newImage" accept="image/*" />
                        <flux:description>The image must not be larger than 2MB.</flux:description>
                        <flux:error name="newImage" />

                        @if ($newImage)
                            <div class="mt-4">
                                <flux:text class="text-sm mb-2">Image Preview:</flux:text>
                                <img src="{{ $newImage->temporaryUrl() }}" alt="New event image" class="max-w-xs h-auto rounded-lg shadow-md">
                            </div>
                        @endif
                    </flux:field>
                </div>

                <div class="flex justify-end gap-x-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" type="submit">{{ $eventId ? 'Update' : 'Create' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="deleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Event</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to delete this event?</p>
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
