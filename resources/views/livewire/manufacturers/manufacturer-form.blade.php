<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            @if (isset($id))
                {{ __('manufacturers.labels.edit_form_title') }}
            @else
                {{ __('manufacturers.labels.create_form_title') }}
            @endif
        </h3>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="name">{{ __('manufacturers.attributes.name') }}</label>
            </div>
            <div class="">
                <x-wireui-input placeholder="{{ __('Enter') }}" wire:model="name" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="address">{{ __('manufacturers.attributes.address') }}</label>
            </div>
            <div class="">
                <x-wireui-textarea placeholder="{{ __('Enter') }}" wire:model="address" />
            </div>
        </div>

        <hr class="my-2">
        <div class="flex justify-end pt-2">
            <x-wireui-button href="{{ route('manufacturers.index') }}" secondary class="mr-2"
                label="{{ __('Cancel') }}" />
            <x-wireui-button type="submit" primary label="{{ __('Save') }}" spinner />
        </div>
    </form>
</div>
