<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Contracts\Repositories\AdminPaymentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\FilterAdminPaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentAdminStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function __construct(
        protected AdminPaymentRepositoryInterface $adminPaymentRepository
    ) {}

    /**
     * Admin: View all payments
     */
    public function index(FilterAdminPaymentRequest $query): View
    {
        return view('payments.admin.index', [
            'payments' => $this->adminPaymentRepository->getAllPayments(
                10,                  // Pagination limit
                'all',               // Show all payments
                $query->validated()  // Apply filters
            )
        ]);
    }

    /**
     * Admin: View all pending payments
     */
    public function pending(FilterAdminPaymentRequest $query): View
    {
        return view('payments.admin.status.pending', [
            'pendingPayments' => $this->adminPaymentRepository->getAllPayments(
                10,                  // Pagination limit
                'pending',           // Filter by 'pending' status
                $query->validated()  // Apply filters
            )
        ]);
    }

    /**
     * Admin: View all failed payments
     */
    public function failed(FilterAdminPaymentRequest $query): View
    {
        return view('payments.admin.status.failed', [
            'failedPayments' => $this->adminPaymentRepository->getAllPayments(
                10,                  // Pagination limit
                'failed',            // Filter by 'failed' status
                $query->validated()  // Apply filters
            )
        ]);
    }

    /**
     * Admin: View all successful payments
     */
    public function success(FilterAdminPaymentRequest $query): View
    {
        return view('payments.admin.status.successful', [
            'successfulPayments' => $this->adminPaymentRepository->getAllPayments(
                10,                  // Pagination limit
                'success',           // Filter by 'success' status
                $query->validated()  // Apply filters
            )
        ]);
    }

    /**
     * Admin: View specific payment details
     */
    public function show(string $txnId): View
    {
        return view('payments.admin.show', [
            'payment' => $this->adminPaymentRepository->getPayment($txnId) // Fetch payment by txnId
        ]);
    }

    /**
     * Admin: Update payment status (Success / Failed)
     */
    public function updateStatus(string $txnId, UpdatePaymentAdminStatus $request): RedirectResponse
    {
        // Update the payment status (e.g., Success or Failed)
        $this->adminPaymentRepository->updatePaymentStatus(
            $txnId,
            $request->validated()['status']  // Get the new status from the request
        );

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function getGcashReceipt($payment)
{
    // Check if the payment method is GCash and the receipt path is set
    if ($payment->method == 'GCASH' && $payment->gcash_receipt_path) {
        return asset('storage/' . $payment->gcash_receipt_path); // Generate the URL
    }
    return null; // If no receipt exists, return null
}

}
