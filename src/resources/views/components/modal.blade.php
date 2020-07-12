<div x-data="window.modal()" @open-modal.window="open($event.detail)" @close-modal.window="close()">
    <div x-show="isOpening()">
        <div
                :class="{ 'opacity-0': isOpening(), 'opacity-100': isOpen() }"
                class="fixed z-50 top-0 left-0 w-full h-full outline-none transition-opacity duration-200 linear"
                tabindex="-1"
                role="dialog"
        >
            <div
                    :class="{ 'mt-4': isOpening(), 'mt-8': isOpen() }"
                    class="relative w-auto pointer-events-none max-w-lg mt-8 mx-auto transition-all duration-200 ease-out"
                    x-html="html"
            ></div>
        </div>
        <div
                :class="{ 'opacity-25': isOpen() }"
                class="z-40 fixed top-0 left-0 bottom-0 right-0 bg-black opacity-0 transition-opacity duration-200 linear"
        ></div>
    </div>
</div>
