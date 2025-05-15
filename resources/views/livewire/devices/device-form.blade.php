<div class="p-2">
    <form wire:submit.prevent="submit">
        <h3 class="text-xl font-semibold text-gray-800 leading-tight mb-2">
            {{ $device?->id ? 'Редагувати пристрій' : 'Створити пристрій' }}
        </h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="name">Назва</label>
                <x-input wire:model.defer="name" id="name" class="w-full" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="status">Статус</label>
                <select wire:model.defer="status" id="status" class="w-full border rounded px-2 py-1">
                    <option value="active">Активний</option>
                    <option value="maintenance">Обслуговування</option>
                    <option value="inactive">Неактивний</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="address">Адреса</label>
                <x-input wire:model.defer="address" id="address" class="w-full" />
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="longitude">Довгота</label>
                <x-input type="number" step="any" wire:model.defer="longitude" id="longitude" class="w-full" />
                @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="latitude">Широта</label>
                <x-input type="number" step="any" wire:model.defer="latitude" id="latitude" class="w-full" />
                @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-2">
            <x-button href="{{ route('devices.index') }}" secondary label="Скасувати" />
            <x-button type="submit" primary label="{{ $device?->id ? 'Оновити' : 'Створити' }}" spinner />
        </div>
    </form>
</div>
