<div class="col-md-12">
    <div class="form-inner">
        <label for="{{ $name }}">{{ $label }}</label>

    <input
    type="tel"
    name="{{ $name }}"
    id="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
/>


        <span class="text-danger fs-6">{{ $errors->first($name) }}</span>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function(){

    const input  = $('#{{ $name }}');
    const prefix = "+63";

    function formatNumber(raw) {
        raw = raw.replace(/\D/g, ""); // only digits

        if (raw.startsWith("63")) {
            raw = raw.substring(2);
        }

        raw = raw.substring(0, 10); // PH mobile = 10 digits after 63

        // Format 912 345 6789
        if (raw.length >= 7) {
            return raw.replace(/(\d{3})(\d{3})(\d{0,4})/, "$1 $2 $3").trim();
        }

        if (raw.length >= 4) {
            return raw.replace(/(\d{3})(\d{0,3})/, "$1 $2").trim();
        }

        return raw;
    }

    function enforcePHFormat() {
        let val = input.val().trim();

        // If empty, set base
        if (val === "") {
            input.val(prefix + " ");
            return;
        }

        // If user erased the prefix
        if (!val.startsWith(prefix)) {
            let digits = val.replace(/\D/g, "");
            if (digits.startsWith("63")) digits = digits.substring(2);
            input.val(prefix + " " + formatNumber(digits));
            return;
        }

        // Extract digits after +63 and reformat
        let digits = val.replace(prefix, "").replace(/\D/g, "");
        input.val(prefix + " " + formatNumber(digits));
    }

    // Apply on load
    enforcePHFormat();

    // Apply while typing
    input.on("input", function () {
        enforcePHFormat();
    });

    // Prevent deleting the +63
    input.on("keydown", function (e) {
        if (this.selectionStart <= 4 && (e.key === "Backspace" || e.key === "Delete")) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
