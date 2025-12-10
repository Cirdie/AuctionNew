@props([
    'selectedCountry' => 'PH',
    'selectedProvince' => null,
    'selectedProvinceCode' => null,
    'selectedCity' => null,
    'selectedCityCode' => null,
    'selectedBarangay' => null,
    'selectedBarangayCode' => null,
    'admin' => false,
    'hasLabels' => false,
])
<div class="{{ $hasLabels ? 'col-xl-6 col-md-6' : 'col-md-12' }}">
    <div class="form-inner">
        <label>Country *</label>
        <select name="country" id="country">
            <option value="PH" selected>Philippines</option>
        </select>
        <span class="text-danger">{{ $errors->first('country') }}</span>
    </div>
</div>

<div class="{{ $hasLabels ? 'col-xl-6 col-md-6' : 'col-md-12' }}">
    <div class="form-inner">
        <label>Province *</label>
        <select name="province" id="province">
            <option value="">Select Province</option>
        </select>

        <input type="hidden" name="province_code" id="province_code" value="{{ $selectedProvinceCode }}">
        <span class="text-danger">{{ $errors->first('province') }}</span>
    </div>
</div>

<div class="{{ $hasLabels ? 'col-xl-6 col-md-6' : 'col-md-12' }}">
    <div class="form-inner">
        <label>City / Municipality *</label>
        <select name="city" id="city">
            <option value="">Select City</option>
        </select>

        <input type="hidden" name="city_code" id="city_code" value="{{ $selectedCityCode }}">
        <span class="text-danger">{{ $errors->first('city') }}</span>
    </div>
</div>

<div class="{{ $hasLabels ? 'col-xl-6 col-md-6' : 'col-md-12' }}">
    <div class="form-inner">
        <label>Barangay *</label>
        <select name="barangay" id="barangay">
            <option value="">Select Barangay</option>
        </select>

        <input type="hidden" name="barangay_code" id="barangay_code" value="{{ $selectedBarangayCode }}">
        <span class="text-danger">{{ $errors->first('barangay') }}</span>
    </div>
</div>

@push('scripts')
<script>
async function getProvinces() {
    const res = await fetch(`/api/states/PH`);
    const data = await res.json();

    let options = `<option value="">Select Province</option>`;
    data.data.forEach(p => {
        options += `<option value="${p.name}" data-code="${p.code}">${p.name}</option>`;
    });

    $("#province").html(options).niceSelect('update');

    @if($selectedProvince && $selectedProvinceCode)
        $("#province").val("{{ $selectedProvince }}").niceSelect('update');
        $("#province_code").val("{{ $selectedProvinceCode }}");
        await getCities("{{ $selectedProvinceCode }}");
    @endif
}

async function getCities(provinceCode) {
    const res = await fetch(`/api/cities/PH/${provinceCode}`);
    const data = await res.json();

    let options = `<option value="">Select City</option>`;
    data.data.forEach(c => {
        options += `<option value="${c.name}" data-code="${c.code}">${c.name}</option>`;
    });

    $("#city").html(options).niceSelect('update');

    @if($selectedCity && $selectedCityCode)
        $("#city").val("{{ $selectedCity }}").niceSelect('update');
        $("#city_code").val("{{ $selectedCityCode }}");
        await getBarangays("{{ $selectedCityCode }}");
    @endif
}

async function getBarangays(cityCode) {
    const res = await fetch(`/api/barangays/${cityCode}`);
    const data = await res.json();

    let options = `<option value="">Select Barangay</option>`;
    data.data.forEach(b => {
        options += `<option value="${b.name}" data-code="${b.code}">${b.name}</option>`;
    });

    $("#barangay").html(options).niceSelect('update');

    @if($selectedBarangay && $selectedBarangayCode)
        $("#barangay").val("{{ $selectedBarangay }}").niceSelect('update');
        $("#barangay_code").val("{{ $selectedBarangayCode }}");
    @endif
}

// Change Listeners
$("#province").on("change", function () {
    let code = $(this).find(":selected").data("code");
    $("#province_code").val(code);
    getCities(code);
});

$("#city").on("change", function () {
    let code = $(this).find(":selected").data("code");
    $("#city_code").val(code);
    getBarangays(code);
});

$("#barangay").on("change", function () {
    let code = $(this).find(":selected").data("code");
    $("#barangay_code").val(code);
});

// LOAD EVERYTHING ON PAGE LOAD
document.addEventListener("DOMContentLoaded", function() {
    getProvinces();
});
</script>
@endpush
