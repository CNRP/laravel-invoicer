
@props(['items'])

<div class="mt-6">
    <h3 class="text-lg font-medium">Items</h3>
    @foreach ($items as $index => $item)
        <div class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-3">
            <div>
                <label for="item_name_{{ $index }}" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="item_name_{{ $index }}" wire:model.lazy="items.{{ $index }}.name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('items.' . $index . '.name')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="item_quantity_{{ $index }}" class="block text-sm font-medium text-gray-700">Quantity:</label>
                <input type="number" id="item_quantity_{{ $index }}" wire:model.lazy="items.{{ $index }}.quantity" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('items.' . $index . '.quantity')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="item_price_{{ $index }}" class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="number" id="item_price_{{ $index }}" wire:model.lazy="items.{{ $index }}.price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('items.' . $index . '.price')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-span-1 text-right sm:col-span-3">
                <button type="button" wire:click="removeItem({{ $index }})" class="px-2 py-1 mt-2 text-white bg-red-500 rounded">Remove Item</button>
            </div>
        </div>
    @endforeach

    <button type="button" wire:click="addItem" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Add Item</button>
</div>
