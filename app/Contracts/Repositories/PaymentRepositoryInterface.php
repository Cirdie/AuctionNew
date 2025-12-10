<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentRepositoryInterface
{
    /**
     * Get all user payments (purchase history or sales)
     */
    public function getUserPayments(
        User $user,
        string $type,
        int $limit = 10,
        array $filters = null
    ): LengthAwarePaginator;

    /**
     * Get a single user payment
     */
    public function getUserPayment(
        User $user,
        string $txnId
    ): \App\Models\Payment;

    /**
     * Create a payment for an accepted bid.
     * Now accepts additional details like address & gcash receipt.
     */
    public function pay(
        string $bidId,
        User $user,
        string $method,
        array $extra = []   // ✅ ADDED
    ): string;

    /**
     * Confirmation is now handled manually by admin.
     */
    public function confirm(
        string $txnId,
        string $transactionId = null
    ): string;
}
