<div x-data="{ showColumnManagement: false }">
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-700">Invoice Items</h2>
        <button type="button" @click="showColumnManagement = !showColumnManagement" class="px-4 py-2 text-white bg-blue-500 rounded">
            <span x-show="!showColumnManagement">Manage Columns</span>
            <span x-show="showColumnManagement">Hide</span>
        </button>
    </div>

    <div x-show="showColumnManagement" class="mb-4" x-cloak>
        <label for="new_column_name" class="block text-sm font-medium text-gray-700">New Column Name</label>
        <input type="text" id="new_column_name" wire:model.lazy="newColumnName" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
        <button type="button" wire:click="addColumn" class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">Add Column</button>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                @foreach ($columns as $columnKey => $columnLabel)
                    <th class="px-4 py-2 text-left border-b">
                        {{ $columnLabel }}
                        @if ($columnKey !== 'price')
                            <button type="button" wire:click="removeColumn('{{ $columnKey }}')" class="ml-2 text-red-500">×</button>
                        @endif
                    </th>
                @endforeach
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    @foreach ($columns as $columnKey => $columnLabel)
                        <td class="px-4 py-2 border-b">
                            <input type="text" id="item_{{ $columnKey }}_{{ $index }}" wire:model.lazy="items.{{ $index }}.{{ $columnKey }}" class="block w-full border-gray-300 rounded-md shadow-sm">
                        </td>
                    @endforeach
                    <td class="px-4 py-2 text-right border-b">
                        <button type="button" wire:click="removeItem({{ $index }})" class="px-2 py-1 text-white bg-red-500 rounded">Remove Item</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="button" wire:click="addItem" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Add Item</button>
</div>
