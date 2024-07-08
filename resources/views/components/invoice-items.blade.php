@props(['items', 'columns'])

<div class="mt-6">
    <h3 class="text-lg font-medium">Items</h3>
    @foreach ($items as $index => $item)
        <div class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-{{ count($columns) + 1 }}">
            @foreach ($columns as $columnKey => $columnLabel)
                <div>
                    <label for="item_{{ $columnKey }}_{{ $index }}" class="block text-sm font-medium text-gray-700">{{ $columnLabel }}:</label>
                    <input type="text" id="item_{{ $columnKey }}_{{ $index }}" wire:model.lazy="items.{{ $index }}.{{ $columnKey }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    @error('items.' . $index . '.' . $columnKey)
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <div>
                <label for="item_price_{{ $index }}" class="block text-sm font-medium text-gray-700">Price:</label>
                <input type="number" id="item_price_{{ $index }}" wire:model.lazy="items.{{ $index }}.price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('items.' . $index . '.price')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-span-1 text-right sm:col-span-{{ count($columns) + 1 }}">
                <button type="button" wire:click="removeItem({{ $index }})" class="px-2 py-1 mt-2 text-white bg-red-500 rounded">Remove Item</button>
            </div>
        </div>
    @endforeach

    <button type="button" wire:click="addItem" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Add Item</button>
    <button type="button" wire:click="addColumn" class="px-4 py-2 mt-4 ml-2 text-white bg-green-500 rounded">Add Column</button>
</div>
