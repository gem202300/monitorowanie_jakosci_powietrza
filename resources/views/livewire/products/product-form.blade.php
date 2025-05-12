<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            @if (isset($product->id))
                {{ __('products.labels.edit_form_title') }}
            @else
                {{ __('products.labels.create_form_title') }}
            @endif
        </h3>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="name">{{ __('products.attributes.name') }}</label>
            </div>
            <div class="">
                <x-wireui-input placeholder="{{ __('Enter') }}" wire:model="name" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="description">{{ __('products.attributes.description') }}</label>
            </div>
            <div class="">
                <x-wireui-textarea placeholder="{{ __('Enter') }}" wire:model="description" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="price">{{ __('products.attributes.price') }}</label>
            </div>
            <div class="">
                <x-wireui-currency thousands=" " precision="2" placeholder="{{ __('Enter') }}" wire:model="price" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="manufacturer_id">{{ __('products.attributes.manufacturer') }}</label>
            </div>
            <div class="">
                <x-wireui-select placeholder="{{ __('Select') }}" wire:model.defer="manufacturer_id" :async-data="route('manufacturers.search')"
                    option-label="name" option-value="id" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="categories">{{ __('products.attributes.categories') }}</label>
            </div>
            <div class="">
                <x-wireui-select multiselect placeholder="{{ __('Select') }}" wire:model="category_ids"
                    :async-data="route('categories.search')" option-label="name" option-value="id" />
            </div>
        </div>

        <hr class="my-2">
        <div class="grid grid-cols-2 gap-2">
            <div class="">
                <label for="image">{{ __('products.attributes.image') }}</label>
            </div>
            <div class="">
                @if (isset($imageUrl))
                    <div class="relative">
                        <img class="w-full" src="{{ $imageUrl }}" alt="{{ $name }}">
                        <div class="absolute right-2 top-2 h-16">
                            <x-wireui-mini-button outline xs secondary icon="trash" wire:click="confirmDeleteImage" />
                        </div>
                    </div>
                @else
                    <x-wireui-input type="file" wire:model="uploadedImage" />
                @endif
            </div>
        </div>

        <hr class="my-2">
        <div class="flex justify-end pt-2">
            <x-wireui-button href="{{ route('products.index') }}" secondary class="mr-2"
                label="{{ __('Cancel') }}" />
            <x-wireui-button type="submit" primary label="{{ __('Save') }}" spinner="submit" />
        </div>
    </form>
</div>
