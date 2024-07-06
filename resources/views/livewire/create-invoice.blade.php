<div class="flex flex-col gap-4">
    <livewire:flash-message />

    <x-modal name="create-invoice" :title="'Create Invoice'">
        <div>
            <form wire:submit.prevent="createInvoice" class="space-y-6">
                @foreach ($config['invoice_structure'] as $sectionKey => $sectionData)
                    <fieldset class="p-4 border rounded-md" x-data="{ open: true }">
                        <legend class="text-lg font-medium">
                            <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
                                {{ ucfirst(str_replace('_', ' ', $sectionKey)) }}
                                <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </legend>
                        <div x-show="open" class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-2">
                            @foreach ($sectionData as $key => $data)
                                @if (isset($fields[$sectionKey][$key]))
                                    @if (isset($data['fields']))
                                        <div class="col-span-1 sm:col-span-2">
                                            <h4 class="mb-2 font-medium text-md">{{ ucfirst(str_replace('_', ' ', $key)) }}</h4>
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                @foreach ($data['fields'] as $fieldKey => $fieldData)
                                                    @if (isset($fields[$sectionKey][$key]['value'][$fieldKey]))
                                                        <div x-data="{ fieldEnabled: @entangle('fields.' . $sectionKey . '.' . $key . '.value.' . $fieldKey . '.enabled') }" class="col-span-1 sm:col-span-2">
                                                            <div class="flex items-center">
                                                                <label for="{{ $sectionKey }}_{{ $key }}_{{ $fieldKey }}" class="block text-sm font-medium text-gray-700">
                                                                    {{ ucfirst(str_replace('_', ' ', $fieldKey)) }}:
                                                                </label>
                                                                <input type="checkbox" x-model="fieldEnabled" class="ml-2">
                                                                <span x-text="fieldEnabled ? 'Enabled' : 'Disabled'" class="ml-1 text-sm" :class="fieldEnabled ? 'text-green-500' : 'text-red-500'"></span>
                                                            </div>
                                                            <div class="mt-1">
                                                                <template x-if="fieldEnabled">
                                                                    <input type="text"
                                                                           id="{{ $sectionKey }}_{{ $key }}_{{ $fieldKey }}"
                                                                           wire:model="fields.{{ $sectionKey }}.{{ $key }}.value.{{ $fieldKey }}.value"
                                                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                                                </template>
                                                                <template x-if="!fieldEnabled">
                                                                    <span class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm">
                                                                        {{ $fields[$sectionKey][$key]['value'][$fieldKey]['value'] ?? $fieldData['default'] }}
                                                                    </span>
                                                                </template>
                                                                @error("fields.{$sectionKey}.{$key}.value.{$fieldKey}.value")
                                                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div x-data="{ fieldEnabled: @entangle('fields.' . $sectionKey . '.' . $key . '.enabled') }" class="col-span-1 sm:col-span-2">
                                            <div class="flex items-center">
                                                <label for="{{ $sectionKey }}_{{ $key }}" class="block text-sm font-medium text-gray-700">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                                </label>
                                                <input type="checkbox" x-model="fieldEnabled" class="ml-2">
                                                <span x-text="fieldEnabled ? 'Enabled' : 'Disabled'" class="ml-1 text-sm" :class="fieldEnabled ? 'text-green-500' : 'text-red-500'"></span>
                                            </div>
                                            <div class="mt-1">
                                                <template x-if="fieldEnabled">
                                                    <input type="text"
                                                           id="{{ $sectionKey }}_{{ $key }}"
                                                           wire:model="fields.{{ $sectionKey }}.{{ $key }}.value"
                                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                                </template>
                                                <template x-if="!fieldEnabled">
                                                    <span class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm">
                                                        {{ $fields[$sectionKey][$key]['value'] ?? $data['default'] }}
                                                    </span>
                                                </template>
                                                @error("fields.{$sectionKey}.{$key}.value")
                                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach

                <div class="mt-6">
                    <h3 class="text-lg font-medium">Items</h3>
                    @foreach ($items as $index => $item)
                        <div class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-3">
                            <div>
                                <label for="item_name_{{ $index }}" class="block text-sm font-medium text-gray-700">Name:</label>
                                <input type="text" id="item_name_{{ $index }}" wire:model="items.{{ $index }}.name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('items.' . $index . '.name')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="item_quantity_{{ $index }}" class="block text-sm font-medium text-gray-700">Quantity:</label>
                                <input type="number" id="item_quantity_{{ $index }}" wire:model="items.{{ $index }}.quantity" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                @error('items.' . $index . '.quantity')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="item_price_{{ $index }}" class="block text-sm font-medium text-gray-700">Price:</label>
                                <input type="number" id="item_price_{{ $index }}" wire:model="items.{{ $index }}.price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
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

                <div class="mt-6 text-right">
                    <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Create Invoice</button>
                </div>
            </form>
        </div>

        <x-slot name="footer">
            <button @click="$dispatch('close-modal')" class="mr-2 modal-button">Cancel</button>
        </x-slot>
    </x-modal>
</div>
