<div>
    <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true;"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <div class="flex items-center space-x-4">
            @if ($photo)
                <img class="h-12 w-12 rounded-lg overflow-hidden bg-gray-100" src="{{ $photo->temporaryUrl() }}" alt="">
            @elseif($value)
                <img class="h-12 w-12 rounded-lg overflow-hidden bg-gray-100" src="{{ $value }}" alt="" />
            @else
                <span class="h-12 w-12 rounded-lg overflow-hidden bg-gray-100">
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </span>
            @endif
            <button type="button"
                    class="py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    x-on:click="$refs.input.click()"
            >
                Change
            </button>
            <input type="file" wire:model="photo" class="sr-only" x-ref="input">
            <div x-show="isUploading" x-cloak class="relative flex-1">
                <div class="flex mb-2 items-center justify-end">
                    <span class="text-xs font-semibold inline-block text-gray-600" x-text="progress + ' %'"></span>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100 w-full">
                    <div :style="'width:' + progress + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-cyan-600"></div>
                </div>
            </div>
        </div>
    </div>

    @error('photo')
    <div>
        <span class="error">{{ $message }}</span>
    </div>
    @enderror
</div>
