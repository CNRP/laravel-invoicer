@props(['previewHtml'])

<div x-data="{ showPreview: false }" class="relative">
    <div class="transition-all duration-500 transform" :class="{'w-[210mm] opacity-100': showPreview, 'w-0 opacity-0': !showPreview}">
        <div style="width: 210mm; height: 297mm;" class="h-full p-8 bg-white border border-black shadow-lg" :class="{'block': showPreview, 'hidden': !showPreview}">
            {!! $previewHtml !!}
        </div>
    </div>

    <div class="mt-4">
        <button type="button" @click="showPreview = !showPreview" class="px-4 py-2 text-white bg-green-500 rounded" x-text="showPreview ? 'Hide Preview' : 'Show Preview'"></button>
    </div>
</div>
