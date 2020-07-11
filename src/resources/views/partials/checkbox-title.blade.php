<div class="whitespace-no-wrap" x-data="{ checkAll: false }">
    <label class="inline-flex items-center" x-ref="checkbox">
        <input
                type="checkbox"
                class="form-checkbox h-5 w-5 text-primary-500"
                x-model="checkAll"
                @toggle-check.window="checkAll = false"
                @click="$dispatch('toggle-all-check', checkAll)"
        >
    </label>
</div>
