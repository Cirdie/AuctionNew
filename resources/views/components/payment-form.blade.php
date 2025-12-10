    @props(['bid', 'user'])

<form action="{{ route('user.payments.pay', $bid) }}"
        method="POST"
        enctype="multipart/form-data"
        class="w-100">

        @csrf

        <h4 class="mb-3 text-center">Complete Your Payment</h4>

        {{-- PAYMENT METHOD --}}
        <div class="form-inner mb-4">
            <label>Select Payment Method *</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="">-- Select Method --</option>
                <option value="COD">Cash on Delivery</option>
                <option value="GCASH">GCash</option>
            </select>
            <span class="text-danger">{{ $errors->first('payment_method') }}</span>
        </div>

        {{-- DELIVERY ADDRESS --}}
        <h5 class="mt-4">Delivery Address</h5>
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

        {{-- Additional Street Address --}}
        <div class="form-inner mt-3">
            <label>Street / House No. / Additional Details *</label>
            <textarea class="form-control" name="address_details" rows="2" required></textarea>
            <span class="text-danger">{{ $errors->first('address_details') }}</span>
        </div>

        {{-- GCASH SECTION --}}
        <div id="gcash-section" class="d-none mt-4">
            <h5>GCash Payment</h5>

            <div class="text-center mt-2">
                <img src="/storage/gcash_qr.png" alt="GCash QR" width="250" class="mb-2">
                <p class="fw-bold mb-2">GCash Number: 09XXXXXXXXX</p>
            </div>

            <div class="form-inner">
                <label>Upload GCash Receipt *</label>
                <input type="file" name="proof_image" class="form-control" accept="image/*">
                <span class="text-danger">{{ $errors->first('proof_image') }}</span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4">
            Submit Payment
        </button>
    </form>

    @push('scripts')
    <script>
        document.getElementById('payment_method').addEventListener('change', function () {
            const gcashSection = document.getElementById('gcash-section');

            if (this.value === 'GCASH') {
                gcashSection.classList.remove('d-none');
            } else {
                gcashSection.classList.add('d-none');
            }
        });
    </script>
    @endpush
