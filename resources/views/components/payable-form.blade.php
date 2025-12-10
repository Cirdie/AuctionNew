@props(['bid', 'user'])

<div class="form-wrapper">
    <form id="pay-form-{{ $bid->id }}"
          action="{{ route('user.pay', ['bids' => $bid->id]) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="row">

            {{-- AMOUNT --}}
            <div class="col-md-6 mb-4">
                <x-input-field
                    name="amount"
                    type="number"
                    label="Amount"
                    value="{{ $bid->amount }}"
                    :readonly="true"
                />
            </div>

            {{-- PAYMENT METHOD BUTTONS --}}
            <div class="col-md-6 mb-4">
                <label class="fw-bold d-block mb-2">Payment Method *</label>

                <input type="hidden" name="payment_method"
                       id="payment_method_input_{{ $bid->id }}">

                <div class="d-flex gap-2">

                    <button type="button"
                            class="paymethod-btn btn btn-outline-primary w-50"
                            data-method="COD"
                            data-bid="{{ $bid->id }}">
                        Cash on Delivery
                    </button>

                    <button type="button"
                            class="paymethod-btn btn btn-outline-primary w-50"
                            data-method="GCASH"
                            data-bid="{{ $bid->id }}">
                        GCash
                    </button>

                </div>
            </div>

            {{-- GCash SECTION --}}
            <div class="col-12 mt-4 d-none gcash-box gcash-box-{{ $bid->id }}">
                <h5>GCash Payment</h5>

                <div class="text-center mb-3">
                    <img src="{{ asset('storage/gcash_qr.png') }}"
                         alt="GCash QR"
                         width="200">

                    <p class="fw-bold mt-2">GCash Number: 09XXXXXXXXX</p>
                </div>

                <label>Upload GCash Receipt *</label>
                <input type="file"
                       name="proof_image"
                       class="form-control"
                       accept="image/*">
            </div>

            {{-- DELIVERY ADDRESS --}}
            <div class="col-12 mt-4">
                <h5>Delivery Address</h5>
            </div>

            <div class="row">
                <x-countries-selectable
                    :admin="false"
                    has-labels="true"
                    :selectedCountry="'PH'"
                    :selectedProvince="$user->province"
                    :selectedProvinceCode="$user->province_code"
                    :selectedCity="$user->city"
                    :selectedCityCode="$user->city_code"
                    :selectedBarangay="$user->barangay"
                    :selectedBarangayCode="$user->barangay_code"
                />
            </div>

            {{-- STREET DETAILS --}}
            <div class="col-12 mt-3">
                <label>Street / House No. / Additional Details *</label>
                <textarea name="address_details"
                          class="form-control"
                          rows="2"
                          required></textarea>
            </div>

            {{-- SUBMIT --}}
            <div class="col-12 mt-4">
                <button type="submit" class="account-btn w-100">
                    <i class="bi bi-credit-card-2-front-fill"></i>
                    SUBMIT PAYMENT
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const bidId = "{{ $bid->id }}";

    const methodInput = document.getElementById("payment_method_input_" + bidId);
    const gcashBox = document.querySelector(".gcash-box-" + bidId);
    const buttons = document.querySelectorAll(".paymethod-btn[data-bid='{{ $bid->id }}']");

    if (!methodInput || !gcashBox || !buttons.length) {
        console.warn("Payment form elements missing for bid:", bidId);
        return;
    }

    buttons.forEach(btn => {
        btn.addEventListener("click", function () {

            const method = this.dataset.method;
            methodInput.value = method;

            // Highlight button
            buttons.forEach(b => {
                b.classList.remove("btn-primary");
                b.classList.add("btn-outline-primary");
            });

            this.classList.add("btn-primary");
            this.classList.remove("btn-outline-primary");

            // Toggle GCash box
            gcashBox.classList.toggle("d-none", method !== "GCASH");
        });
    });

});
</script>

<style>
.paymethod-btn {
    padding: 12px;
    font-weight: 600;
    border-radius: 8px;
    transition: 0.2s ease-in-out;
}
.btn-primary {
    color: #fff !important;
}
</style>
@endpush
