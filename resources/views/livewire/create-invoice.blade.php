<div class="flex flex-col gap-4">
    <livewire:flash-message />

    <x-modal name="create-invoice" :title="'Create Invoice'">
        <div>
            <form wire:submit.prevent="createInvoice" class="">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo URL:</label>
                        <input type="text" id="logo" wire:model="fields.logo" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('fields.logo')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number:</label>
                        <input type="text" id="invoice_number" wire:model="fields.invoice_number" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('fields.invoice_number')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date:</label>
                        <input type="date" id="date" wire:model="fields.date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @error('fields.date')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <fieldset class="p-4 border rounded-md" x-data="{ open: false }">
                    <legend class="text-lg font-medium">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
                            From:
                            <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                            <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </legend>
                    <div x-show="open" class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-2">
                        <div>
                            <label for="from_name" class="block text-sm font-medium text-gray-700">Name:</label>
                            <input type="text" id="from_name" wire:model="fields.from.name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.name')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="from_phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                            <input type="text" id="from_phone" wire:model="fields.from.phone" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.phone')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="from_email" class="block text-sm font-medium text-gray-700">Email:</label>
                            <input type="text" id="from_email" wire:model="fields.from.email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.email')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label for="from_address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1:</label>
                            <input type="text" id="from_address_line_1" wire:model="fields.from.address_line_1" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.address_line_1')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="from_address_line_2" class="block text-sm font-medium text-gray-700">Address Line 2:</label>
                            <input type="text" id="from_address_line_2" wire:model="fields.from.address_line_2" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.address_line_2')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="from_address_line_3" class="block text-sm font-medium text-gray-700">Address Line 3:</label>
                            <input type="text" id="from_address_line_3" wire:model="fields.from.address_line_3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.from.address_line_3')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="p-4 border rounded-md" x-data="{ open: false }">
                    <legend class="text-lg font-medium">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
                            To:
                            <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                            <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </legend>
                    <div x-show="open" class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-2">
                        <div>
                            <label for="to_name" class="block text-sm font-medium text-gray-700">Name:</label>
                            <input type="text" id="to_name" wire:model="fields.to.name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.name')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="to_phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                            <input type="text" id="to_phone" wire:model="fields.to.phone" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.phone')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="to_email" class="block text-sm font-medium text-gray-700">Email:</label>
                            <input type="text" id="to_email" wire:model="fields.to.email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.email')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label for="to_address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1:</label>
                            <input type="text" id="to_address_line_1" wire:model="fields.to.address_line_1" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.address_line_1')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="to_address_line_2" class="block text-sm font-medium text-gray-700">Address Line 2:</label>
                            <input type="text" id="to_address_line_2" wire:model="fields.to.address_line_2" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.address_line_2')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="to_address_line_3" class="block text-sm font-medium text-gray-700">Address Line 3:</label>
                            <input type="text" id="to_address_line_3" wire:model="fields.to.address_line_3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.to.address_line_3')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="p-4 border rounded-md" x-data="{ open: false }">
                    <legend class="text-lg font-medium">
                        <button type="button" @click="open = !open" class="text-left w-full flex justify-between items-center">
                            Additional Details:
                            <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                            <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </legend>
                    <div x-show="open" class="mt-2 space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                            <textarea id="description" wire:model="fields.description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                            @error('fields.description')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_terms" class="block text-sm font-medium text-gray-700">Payment Terms:</label>
                            <textarea id="payment_terms" wire:model="fields.payment_terms" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                            @error('fields.payment_terms')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_details" class="block text-sm font-medium text-gray-700">Payment Details:</label>
                            <textarea id="payment_details" wire:model="fields.payment_details" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                            @error('fields.payment_details')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="footer" class="block text-sm font-medium text-gray-700">Footer:</label>
                            <input type="text" id="footer" wire:model="fields.footer" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @error('fields.footer')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="is_paid" class="block text-sm font-medium text-gray-700">Is Paid:</label>
                            <input type="checkbox" id="is_paid" wire:model="fields.is_paid" class="mt-1">
                            @error('fields.is_paid')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <div>
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
