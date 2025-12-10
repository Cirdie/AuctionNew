@if($payment->method == 'GCASH' && $payment->receipt_url)
    <strong>GCash Receipt:</strong>
    <div class="mt-2">
        <img src="{{ $payment->receipt_url }}"
             alt="GCash Receipt"
             style="max-width: 200px; max-height: 200px; object-fit: cover;">
    </div>
@else
    <p>No receipt available.</p>
@endif
