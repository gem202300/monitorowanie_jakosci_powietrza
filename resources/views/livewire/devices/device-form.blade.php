<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            {{ isset($device->id) ? __('devices.labels.edit_form_title') : __('devices.labels.create_form_title') }}
        </h3>

        <hr class="my-2">

        <x-wireui-input label="{{ __('devices.attributes.name') }}" wire:model="name" placeholder="{{ __('Enter') }}" />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

              <x-wireui-select
            label="{{ __('devices.attributes.status') }}"
            wire:model="status"
            :options="[
                ['label' => 'Active', 'value' => 'active'],
                ['label' => 'Maintenance', 'value' => 'maintenance'],
                ['label' => 'Inactive', 'value' => 'inactive'],
            ]"
            option-label="label"
            option-value="value"
        />

        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        <x-wireui-select
            label="{{ __('devices.attributes.parameters') }}"
            wire:model="selectedParameters"
            :options="$parameters"
            option-label="label"
            option-value="id"
            multiselect
        />
        @error('selectedParameters') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('devices.attributes.address') }}" wire:model="address" placeholder="{{ __('Enter') }}" />
        @error('address') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('devices.attributes.longitude') }}" type="text" wire:model.defer="longitude" placeholder="{{ __('Enter') }}" />
        @error('longitude') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('devices.attributes.latitude') }}" type="text" wire:model.defer="latitude" placeholder="{{ __('Enter') }}" />
        @error('latitude') <span class="text-danger">{{ $message }}</span> @enderror


        <div class="flex justify-end pt-4 space-x-2">
            <div class="flex justify-end pt-4">
        <x-wireui-button 
            href="{{ route('devices.index') }}" 
            secondary 
            label="{{ __('devices.actions.cancel') }}" 
        />

        <x-wireui-button 
            type="submit" 
            primary 
            label="{{ isset($device->id) ? __('devices.actions.edit') : __('devices.actions.create') }}" 
            spinner 
            class="ml-2"
        />
    </div>
    </div>
    </form>
</div>
