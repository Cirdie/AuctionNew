<?php

namespace App\Http\Controllers\User\Payment;

use App\Contracts\Repositories\AuthenticateRepositoryInterface;
use App\Contracts\Repositories\PaymentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePayRequest;
use App\Http\Requests\Payment\FilterUserPaymentRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentRepositoryInterface $paymentRepository,
        protected AuthenticateRepositoryInterface $authRepository
    ) {}

    /**
     * Purchase history (payments the user made as buyer)
     */
    public function index(FilterUserPaymentRequest $filter): View
    {
        return view('payments.user.index', [
            'payments' => $this->paymentRepository->getUserPayments(
                $this->authRepository->user(),
                'payer_id',
                10,
                $filter->validated()
            ),
        ]);
    }

    /**
     * Show a single payment (by txn_id)
     */
    public function show(string $txnId): View
    {
        return view('payments.user.show', [
            'payment' => $this->paymentRepository->getUserPayment(
                $this->authRepository->user(),
                $txnId
            ),
        ]);
    }

    /**
     * Sales history (payments the user received as seller)
     */
    public function sales(): View
    {
        return view('payments.user.sales', [
            'payments' => $this->paymentRepository->getUserPayments(
                $this->authRepository->user(),
                'payee_id',
                10
            ),
        ]);
    }

    /**
     * Submit payment for a winning bid (COD / GCASH)
     */
    public function pay(CreatePayRequest $request, string $bidId)
{
    $user = $this->authRepository->user();

    // BUILD FULL ADDRESS STRING
    $fullAddress = trim(
        ($request->address_details ?? '') . ', ' .
        ($request->barangay ?? '') . ', ' .
        ($request->city ?? '') . ', ' .
        ($request->province ?? '') . ', ' .
        ($request->country ?? '')
    );

    // Handle GCASH receipt upload (optional)
    $gcashPath = null;
    if ($request->payment_method === 'GCASH' && $request->hasFile('proof_image')) {
        $gcashPath = $request->file('proof_image')->store('receipts', 'public');
    }

    // PASS EVERYTHING TO REPO
    $txnId = $this->paymentRepository->pay(
        bidId: $bidId,
        user: $user,
        method: $request->payment_method,
        extra: [
            'delivery_address' => $fullAddress,
            'gcash_receipt_path' => $gcashPath,
        ]
    );

    return redirect()
        ->route('user.listing-bids.show', ['bids' => $bidId])
        ->with('success', "Payment submitted! Transaction ID: $txnId");
}




    /**
     * No more auto confirmation – admin will handle it.
     */
    public function confirm(string $txnId): RedirectResponse
    {
        return back()->with('error', 'Payment confirmation is handled manually by admin.');
    }
}
