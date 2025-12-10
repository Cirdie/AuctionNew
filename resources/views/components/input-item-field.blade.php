<div class="row mb-4">
    <label class="col-md-3 form-label">{{ $label }} :</label>

    <div class="col-md-9">

        {{-- Preset Buttons (Only for datetime-local) --}}
        @if ($type === 'datetime-local')
            <div class="mb-2 d-flex flex-wrap gap-2">

                <button type="button" class="btn btn-sm btn-outline-primary quick-date"
                        data-offset="0" data-target="{{ $name }}">
                    Now
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary quick-date"
                        data-offset="3600" data-target="{{ $name }}">
                    +1 Hour
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary quick-date"
                        data-offset="10800" data-target="{{ $name }}">
                    +3 Hours
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary quick-date"
                        data-offset="86400" data-target="{{ $name }}">
                    Tomorrow
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary quick-date"
                        data-offset="604800" data-target="{{ $name }}">
                    +1 Week
                </button>

            </div>
        @endif


        {{-- Normal Inputs --}}
        @if ($type !== 'datetime-local')
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                class="form-control"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                @if ($readonly) readonly @endif
                @if ($disabled) disabled @endif
            >
        @endif


        {{-- Flatpickr Input for datetime --}}
        @if ($type === 'datetime-local')
            <input
                type="text"
                name="{{ $name }}"
                id="{{ $name }}"
                class="form-control datetimepicker"
                placeholder="{{ $placeholder }}"
                value="{{ $value }}"
                @if ($readonly) readonly @endif
                @if ($disabled) disabled @endif
            >
        @endif


        <span class="text-danger fs-6">{{ $errors->first($name) }}</span>
    </div>
</div>


@if ($type === 'datetime-local')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Initialize flatpickr specifically for this field
    flatpickr("#{{ $name }}", {
        enableTime: true,
        enableSeconds: true,
        time_24hr: true,
        allowInput: true,
        dateFormat: "Y-m-d H:i:S",
    });

    // Quick preset buttons (now correctly target only their own input)
    document.querySelectorAll(".quick-date[data-target='{{ $name }}']").forEach(btn => {
        btn.addEventListener("click", function () {

            let offset = parseInt(this.dataset.offset);
            let targetName = this.dataset.target;

            // new time based on offset
            let newDate = new Date(Date.now() + offset * 1000);

            // update only the specific field
            document.getElementById(targetName)._flatpickr.setDate(newDate, true);

        });
    });

});
</script>
@endpush

@endif
