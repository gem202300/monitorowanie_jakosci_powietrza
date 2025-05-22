<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            {{ isset($parameter->id) ? __('parameter_forma.labels.edit_form_title') : __('parameter_forma.labels.create_form_title') }}
        </h3>

        <hr class="my-2">

        <x-wireui-input label="{{ __('parameter_forma.attributes.name') }}" wire:model="name" placeholder="{{ __('Enter') }}" />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('parameter_forma.attributes.label') }}" wire:model="label" placeholder="{{ __('Enter') }}" />
        @error('label') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('parameter_forma.attributes.unit') }}" wire:model="unit" placeholder="{{ __('Enter') }}" />
        @error('unit') <span class="text-danger">{{ $message }}</span> @enderror

        <x-wireui-input label="{{ __('parameter_forma.attributes.valueType') }}" wire:model.defer="valueType" placeholder="{{ __('Enter') }}" />
        @error('valueType') <span class="text-danger">{{ $message }}</span> @enderror


        <div class="flex justify-end pt-4 space-x-2">
            <div class="flex justify-end pt-4">
        <x-wireui-button 
            href="{{ route('parameters.index') }}" 
            secondary 
            label="{{ __('parameter_forma.actions.cancel') }}" 
        />

        <x-wireui-button 
            type="submit" 
            primary 
            label="{{ isset($parameter->id) ? __('parameter_forma.actions.edit') : __('parameter_forma.actions.create') }}" 
            spinner 
            class="ml-2"
        />
    </div>
    </div>
    </form>
</div>
