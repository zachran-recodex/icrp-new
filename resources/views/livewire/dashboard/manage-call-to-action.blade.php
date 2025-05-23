<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="2">Manage Call to Action</flux:heading>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Call To Action</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="border border-zinc-200 bg-zinc-50 rounded-lg p-6">
        <form wire:submit.prevent="save" class="space-y-6">
            <flux:field>
                <flux:label>Title</flux:label>

                <flux:input wire:model="title" />

                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>Subtitle</flux:label>

                <flux:textarea wire:model="subtitle" rows="3" />

                <flux:error name="subtitle" />
            </flux:field>

            <flux:field>
                <flux:label>Button Text</flux:label>

                <flux:input wire:model="button_text" />

                <flux:error name="button_text" />
            </flux:field>

            <flux:field>
                <flux:label>Image</flux:label>

                @if ($image)
                    <div class="mb-4">
                        <flux:text class="text-sm mb-2">Current Image:</flux:text>
                        <img src="{{ Storage::url($image) }}" alt="Current call to action image" class="max-w-md h-auto rounded-lg shadow-md">
                    </div>
                @endif

                <flux:input type="file" wire:model="newImage" accept="image/*" />

                <flux:description>The image must not be larger than 1MB.</flux:description>

                <flux:error name="newImage" />

                @if ($newImage)
                    <div class="mt-4">
                        <flux:text class="text-sm mb-2">Image Preview:</flux:text>
                        <img src="{{ $newImage->temporaryUrl() }}" alt="New call to action image" class="max-w-md h-auto rounded-lg shadow-md">
                    </div>
                @endif
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save Changes</flux:button>
            </div>
        </form>
    </div>
</div>
