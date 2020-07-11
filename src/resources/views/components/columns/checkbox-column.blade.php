<div class="whitespace-no-wrap" x-data="checkboxHandler({{ $row->Id }})">
    <label class="inline-flex items-center">
        <input
                type="checkbox"
                class="form-checkbox h-5 w-5 text-primary-500"
                x-model="value"
                @click="event($dispatch)"
                @toggle-all-check.window="check($event.detail, $dispatch)"
        >
    </label>
</div>
