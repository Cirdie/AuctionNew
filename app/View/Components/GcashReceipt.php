<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class GcashReceipt extends Component
{
    public $payment;

    // Constructor to accept the payment as a parameter
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    // Render the view for the component
    public function render()
    {
        return view('components.gcash-receipt');
    }

    // Method to get the receipt URL
    public function getReceiptUrl()
    {
        // Log the payment method and receipt path
        Log::debug('Payment method:', ['method' => $this->payment->method]);
        Log::debug('Receipt path:', ['path' => $this->payment->gcash_receipt_path]);

        // Check if method is GCash and receipt path exists
        if ($this->payment->method == 'GCASH' && $this->payment->gcash_receipt_path) {
            return asset('storage/' . $this->payment->gcash_receipt_path);
        }
        return null; // Return null if no receipt exists
    }
}
