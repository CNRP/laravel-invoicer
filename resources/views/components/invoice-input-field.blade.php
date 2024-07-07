@props([
    'sectionKey',
    'fieldKey',
    'label',
    'type' => 'text',
    'wire' => null,
    'defaultValue' => '',
])

<div x-data="{ fieldEnabled: @entangle('fields.' . $sectionKey . '.' . $fieldKey . '.enabled') }" class="col-span-1 sm:col-span-2">
    <div class="flex items-center">
        <label for="{{ $sectionKey }}_{{ $fieldKey }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}:
        </label>
        <input type="checkbox" x-model="fieldEnabled" wire:click="updatePreview" class="ml-2">
        <span x-text="fieldEnabled ? 'Enabled' : 'Disabled'" class="ml-1 text-sm" :class="fieldEnabled ? 'text-green-500' : 'text-gray-500'"></span>
    </div>
    <div class="mt-1">
        <template x-if="fieldEnabled">
            <input type="{{ $type }}"
                   id="{{ $sectionKey }}_{{ $fieldKey }}"
                   wire:model.lazy="fields.{{ $sectionKey }}.{{ $fieldKey }}.value"
                   {{ $wire ?? '' }}
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
        </template>
        <template x-if="!fieldEnabled">
            <span class="block w-full p-2 mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm">
                {{ $defaultValue }}
            </span>
        </template>
        @error("fields.{$sectionKey}.{$fieldKey}.value")
            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
        @enderror
    </div>
</div>
