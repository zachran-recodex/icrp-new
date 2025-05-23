<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Members</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Members</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap gap-4 md:w-2/3">
            <div class="w-full md:w-1/3">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Search members..." icon="magnifying-glass" />
            </div>
            <div class="w-full md:w-1/3">
                <flux:select wire:model.live="dewanFilter">
                    <option value="">All Dewan Categories</option>
                    @foreach($dewanOptions as $dewan)
                        <option value="{{ $dewan }}">{{ $dewan }}</option>
                    @endforeach
                </flux:select>
            </div>
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">
            Add Member
        </flux:button>
    </div>

    <div class="border border-zinc-200 bg-white rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200">
                <thead class="bg-zinc-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                            <div class="flex items-center space-x-1">
                                <span>Name</span>
                                @if ($sortField === 'name')
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
                            Position
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Dewan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('order')">
                            <div class="flex items-center space-x-1">
                                <span>Display Order</span>
                                @if ($sortField === 'order')
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
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($members as $member)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900">
                                <div class="flex items-center">
                                    @if ($member->image && Storage::disk('public')->exists($member->image))
                                        <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="w-10 h-10 object-cover rounded-full mr-3">
                                    @else
                                        <div class="w-10 h-10 flex items-center justify-center bg-zinc-100 rounded-full mr-3">
                                            <flux:icon name="user" variant="mini" class="text-zinc-400" />
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $member->name }}</div>
                                        @if($member->nickname)
                                            <div class="text-xs text-zinc-500">({{ $member->nickname }})</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $member->position }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                <flux:badge>{{ $member->dewan }}</flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500">
                                {{ $member->order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($member->is_alive)
                                    <flux:badge color="green">Living</flux:badge>
                                @else
                                    <flux:badge color="zinc">Deceased</flux:badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="sm" icon="pencil" wire:click="edit({{ $member->id }})" class="text-blue-800! bg-blue-400/20!" />
                                    <flux:button size="sm" icon="trash" wire:click="confirmDelete({{ $member->id }})" class="text-red-800! bg-red-400/20!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 text-center" colspan="6">
                                No members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-zinc-200">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Member Form Modal -->
    <flux:modal name="memberModal" class="min-w-sm md:min-w-2xl lg:min-w-3xl">
        <div class="space-y-6">
            <flux:heading size="lg">{{ $memberId ? 'Edit Member' : 'Add Member' }}</flux:heading>

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
                                :class="activeTab === 'contributions' ? 'border-b-2 border-accent text-accent' : 'text-zinc-500 hover:text-zinc-700'"
                                @click="activeTab = 'contributions'"
                            >
                                Contributions
                            </button>
                            <button
                                type="button"
                                class="px-4 py-2 font-medium text-sm"
                                :class="activeTab === 'legacies' ? 'border-b-2 border-accent text-accent' : 'text-zinc-500 hover:text-zinc-700'"
                                @click="activeTab = 'legacies'"
                            >
                                Legacies
                            </button>
                        </div>
                    </div>

                    <!-- Basic Information Tab -->
                    <div x-show="activeTab === 'basic'" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:field>
                                <flux:label for="name">Name</flux:label>
                                <flux:input id="name" wire:model="name" placeholder="Enter full name" />
                                <flux:error name="name" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="nickname">Nickname (Optional)</flux:label>
                                <flux:input id="nickname" wire:model="nickname" placeholder="Enter nickname if any" />
                                <flux:error name="nickname" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="birth_date">Birth Date</flux:label>
                                <flux:input id="birth_date" wire:model="birth_date" type="date" />
                                <flux:error name="birth_date" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="death_date">Death Date (Optional)</flux:label>
                                <flux:input id="death_date" wire:model="death_date" type="date" />
                                <flux:error name="death_date" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="birth_place">Birth Place</flux:label>
                                <flux:input id="birth_place" wire:model="birth_place" placeholder="Enter birth place" />
                                <flux:error name="birth_place" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="known_as">Known As</flux:label>
                                <flux:input id="known_as" wire:model="known_as" placeholder="E.g., Activist, Scholar" />
                                <flux:error name="known_as" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="position">Position</flux:label>
                                <flux:input id="position" wire:model="position" placeholder="E.g., Chairman, Secretary" />
                                <flux:error name="position" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="dewan">Dewan Category</flux:label>
                                <flux:select id="dewan" wire:model="dewan">
                                    <option value="">Select Dewan</option>
                                    @foreach($dewanOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </flux:select>
                                <flux:error name="dewan" />
                            </flux:field>

                            <flux:field>
                                <flux:label for="order">Display Order</flux:label>
                                <flux:input id="order" wire:model="order" type="number" min="0" />
                                <flux:description>Lower numbers appear first</flux:description>
                                <flux:error name="order" />
                            </flux:field>
                        </div>

                        <flux:field>
                            <flux:label for="quote">Quote (Optional)</flux:label>
                            <flux:textarea id="quote" wire:model="quote" rows="2" placeholder="Notable quote from this member" />
                            <flux:error name="quote" />
                        </flux:field>

                        <flux:field>
                            <flux:label for="biography">Biography</flux:label>
                            <flux:textarea id="biography" wire:model="biography" rows="5" placeholder="Biography and achievements" />
                            <flux:error name="biography" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Photo</flux:label>

                            @if ($image && !$newImage && Storage::disk('public')->exists($image))
                                <div class="mb-4">
                                    <flux:text class="text-sm mb-2">Current Photo:</flux:text>
                                    <img src="{{ Storage::url($image) }}" alt="Current member photo" class="max-w-xs h-auto rounded-lg shadow-md">
                                </div>
                            @endif

                            <flux:input type="file" wire:model="newImage" accept="image/*" />
                            <flux:description>The image must not be larger than 2MB.</flux:description>
                            <flux:error name="newImage" />

                            @if ($newImage)
                                <div class="mt-4">
                                    <flux:text class="text-sm mb-2">Photo Preview:</flux:text>
                                    <img src="{{ $newImage->temporaryUrl() }}" alt="New member photo" class="max-w-xs h-auto rounded-lg shadow-md">
                                </div>
                            @endif
                        </flux:field>
                    </div>

                    <!-- Contributions Tab -->
                    <div x-show="activeTab === 'contributions'" class="space-y-4">
                        <div class="mb-4 border-b pb-4">
                            <flux:heading size="sm">Add New Contribution</flux:heading>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <flux:field>
                                    <flux:label for="new_contribution_title">Title</flux:label>
                                    <flux:input id="new_contribution_title" wire:model="newContribution.title" placeholder="Enter contribution title" />
                                    <flux:error name="newContribution.title" />
                                </flux:field>
                                <flux:field>
                                    <flux:label for="new_contribution_order">Order</flux:label>
                                    <flux:input id="new_contribution_order" wire:model="newContribution.order" type="number" min="0" />
                                    <flux:error name="newContribution.order" />
                                </flux:field>
                            </div>
                            <flux:field class="mt-2">
                                <flux:label for="new_contribution_description">Description</flux:label>
                                <flux:textarea id="new_contribution_description" wire:model="newContribution.description" rows="3" placeholder="Describe the contribution" />
                                <flux:error name="newContribution.description" />
                            </flux:field>
                            <div class="mt-3 flex justify-end">
                                <flux:button variant="filled" icon="plus" wire:click="addContribution" type="button">
                                    Add Contribution
                                </flux:button>
                            </div>
                        </div>

                        <!-- List of contributions -->
                        <div class="space-y-4">
                            <flux:heading size="sm">Contributions</flux:heading>
                            @if (count($contributions) === 0)
                                <flux:text class="text-sm text-zinc-500 italic">No contributions added yet.</flux:text>
                            @else
                                @foreach ($contributions as $index => $contribution)
                                    <div class="border rounded-lg p-4 bg-zinc-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <flux:heading size="sm" class="mb-1">{{ $contribution['title'] }}</flux:heading>
                                                <flux:text variant="subtle" class="mb-2">Order: {{ $contribution['order'] }}</flux:text>
                                                <flux:text>{{ $contribution['description'] }}</flux:text>
                                            </div>
                                            <flux:button size="xs" variant="ghost" wire:click="confirmDeleteContribution({{ $index }})" class="text-red-600">
                                                <flux:icon name="trash" variant="mini" />
                                            </flux:button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Legacies Tab -->
                    <div x-show="activeTab === 'legacies'" class="space-y-4">
                        <div class="mb-4 border-b pb-4">
                            <flux:heading size="sm">Add New Legacy</flux:heading>
                            <flux:field class="mt-3">
                                <flux:label for="new_legacy_content">Legacy Content</flux:label>
                                <flux:textarea id="new_legacy_content" wire:model="newLegacy.content" rows="3" placeholder="Enter legacy content" />
                                <flux:error name="newLegacy.content" />
                            </flux:field>
                            <div class="mt-3 flex justify-end">
                                <flux:button variant="filled" icon="plus" wire:click="addLegacy" type="button">
                                    Add Legacy
                                </flux:button>
                            </div>
                        </div>

                        <!-- List of legacies -->
                        <div class="space-y-4">
                            <flux:heading size="sm">Legacies</flux:heading>
                            @if (count($legacies) === 0)
                                <flux:text class="text-sm text-zinc-500 italic">No legacies added yet.</flux:text>
                            @else
                                @foreach ($legacies as $index => $legacy)
                                    <div class="border rounded-lg p-4 bg-zinc-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <flux:text>{{ $legacy['content'] }}</flux:text>
                                            </div>
                                            <flux:button size="xs" variant="ghost" wire:click="confirmDeleteLegacy({{ $index }})" class="text-red-600">
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
                    <flux:button variant="primary" type="submit">{{ $memberId ? 'Update' : 'Create' }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Member Modal -->
    <flux:modal name="deleteMemberModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Member</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to delete this member?</p>
                <p>This action will also delete all associated contributions and legacies.</p>
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

    <!-- Delete Contribution Modal -->
    <flux:modal name="deleteContributionModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Contribution</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to remove this contribution?</p>
            </flux:text>

            <div class="flex justify-end gap-x-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="deleteContribution" type="button">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Delete Legacy Modal -->
    <flux:modal name="deleteLegacyModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Legacy</flux:heading>

            <flux:text class="mt-2">
                <p>Are you sure you want to remove this legacy?</p>
            </flux:text>

            <div class="flex justify-end gap-x-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="deleteLegacy" type="button">Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
