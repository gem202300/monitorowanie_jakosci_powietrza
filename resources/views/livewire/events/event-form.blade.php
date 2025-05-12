<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            @if (isset($event->id))
                {{ __('events.labels.edit_form_title') }}
            @else
                {{ __('events.labels.create_form_title') }}
            @endif
        </h3>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label for="name">{{ __('events.attributes.name') }}</label>
            </div>
            <div>
                <x-wireui-input placeholder="{{ __('Enter') }}" wire:model="name" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        
        
        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label for="date">{{ __('events.attributes.date') }}</label>
            </div>
            <div>
                <x-wireui-input type="date" placeholder="{{ __('Enter') }}" wire:model="date" />
                @error('date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label for="location">{{ __('events.attributes.location') }}</label>
            </div>
            <div>
                <x-wireui-input placeholder="{{ __('Enter') }}" wire:model="location" />
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label for="max_participants">{{ __('events.attributes.max_participants') }}</label>
            </div>
            <div>
                <x-wireui-input type="number" placeholder="{{ __('Enter') }}" wire:model="max_participants" />
                @error('max_participants') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label for="description">{{ __('events.attributes.description') }}</label>
            </div>
            <div>
                <x-wireui-textarea placeholder="{{ __('Enter') }}" wire:model="description" />
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <hr class="my-2">
        <div class="flex justify-end pt-2">
            <x-wireui-button href="{{ route('events.index') }}" secondary class="mr-2" label="{{ __('Cancel') }}" />
            <x-wireui-button type="submit" primary label="{{ isset($event->id) ? __('events.actions.edit') : __('events.actions.create') }}" spinner />
        </div>
    </form>
</div>
