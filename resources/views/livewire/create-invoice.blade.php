<div class="relative flex flex-col gap-4">
    <x-invoice-modal name="create-invoice" :title="'Create Invoice'">
        <div x-data="{ activeTab: '{{ array_key_first($config['invoice_structure']) }}' }" class="relative max-h-[80dvh] flex gap-8 -translate-y-8">
            <x-invoice-preview :previewHtml="$previewHtml" />

            <div class="relative max-h-[90dvh] mx-auto rounded-lg min-1150">
                <form wire:submit.prevent="createInvoice" class="space-y-6">
                    <div class="p-8 rounded-lg shadow-lg bg-white max-h-[80dvh] overflow-y-auto">
                        <div class="pb-8 mb-4 border-b">
                            <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                                @foreach ($config['invoice_structure'] as $sectionKey => $sectionData)
                                    <button type="button" @click="activeTab = '{{ $sectionKey }}'" class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap" :class="{ 'border-indigo-500 text-indigo-600': activeTab === '{{ $sectionKey }}' }">
                                        {{ ucfirst(str_replace('_', ' ', $sectionKey)) }}
                                    </button>
                                @endforeach
                                <button type="button" @click="activeTab = 'items'" class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'items' }">
                                    Items
                                </button>
                            </nav>
                        </div>

                        @foreach ($config['invoice_structure'] as $sectionKey => $sectionData)
                            <div x-show="activeTab === '{{ $sectionKey }}'">
                                <div class="grid grid-cols-1 gap-4 mt-2 sm:grid-cols-2">
                                    @foreach ($sectionData as $key => $data)
                                        <x-invoice-input-field
                                            :sectionKey="$sectionKey"
                                            :fieldKey="$key"
                                            :label="ucfirst(str_replace('_', ' ', $key))"
                                            :defaultValue="$data['default'] ?? ''"
                                        />
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div x-show="activeTab === 'items'">
                            <livewire:invoice-items :items="$items" />

                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Create Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </x-invoice-modal>
</div>
