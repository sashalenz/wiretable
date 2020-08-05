<div x-data="{ openModal: false }"
     x-cloak
     x-show="openModal"
     class="fixed top-0 inset-x-0 px-4 pt-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center z-30 overflow-hidden"
     @open-modal.window="fetch($event.detail).then(response => response.text()).then(data => window.htmlToElement($refs.html, data)).then(() => window.livewire.rescan()).then(() => openModal = true)"
     @close-modal.window="openModal = false; setTimeout(() => { $refs.html.innerHTML = '' }, 300)"
>
    <div x-show="openModal"
         x-cloak
         x-description="Background overlay, show/hide based on modal state."
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 transition-opacity"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="openModal"
         x-cloak
         x-ref="html"
         x-description="Modal panel, show/hide based on modal state."
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 -translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-white rounded-lg px-4 pt-5 pb-4 shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:py-6"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modal-headline"
    ></div>
</div>
