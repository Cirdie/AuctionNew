<?php

namespace App\Repositories\Payment\User;

use App\Abstracts\BaseCrudRepository;
use App\Models\Payment;
use App\Contracts\Repositories\PaymentRepositoryInterface;
use App\Enums\PaymentStatus;
use App\Exceptions\PaymentException;
use App\Models\User;
use App\Repositories\Bid\User\BidRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentRepository extends BaseCrudRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get user payments (purchase history or sales)
     */
    public function getUserPayments(User $user, string $type, int $limit = 10, array $filters = null): LengthAwarePaginator
    {
        return $this->model->query()
            ->with(['ad:id,title'])
            ->where($type, $user->id)
            ->when($filters, function ($query) use ($filters) {
                $query->when(isset($filters['status']), fn ($q) => $q->where('status', PaymentStatus::from($filters['status'])));
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Get a user's single payment
     */
    public function getUserPayment(User $user, string $txnId): Payment
    {
        return $this->model->query()
            ->with(['ad:id,title,slug', 'bid'])
            ->where('payer_id', $user->id)
            ->where('txn_id', $txnId)
            ->firstOr(function () {
                throw new PaymentException('Payment not found.');
            });
    }

    /**
     * User submits payment (COD or GCASH)
     */
  public function pay(string $bidId, User $user, string $method, array $extra = []): string
{
    $bid = app(BidRepository::class)->findBy('id', $bidId, function () {
        throw new PaymentException('Bid not found.');
    })->load('ad');

    if ($bid->user_id !== $user->id) {
        throw new PaymentException('You cannot pay for this bid.');
    }

    $payment = $this->model->create([
        'bid_id'            => $bid->id,
        'ad_id'             => $bid->ad_id,
        'payer_id'          => $user->id,
        'payee_id'          => $bid->ad->user_id,
        'amount'            => $bid->amount,
        'payment_method'    => $method,
        'delivery_address'  => $extra['delivery_address'] ?? null,
        'gcash_receipt_path'=> $extra['gcash_receipt_path'] ?? null,
        'status'            => PaymentStatus::PENDING,
        'txn_id'            => generate_txn_id('PAY'),
    ]);

    return $payment->txn_id;
}





    /**
     * No more external confirmation — admin handles approval in admin panel.
     */
    public function confirm(string $txnId, string $transactionId = null): string
    {
        throw new PaymentException("Confirmation is handled manually by admin.");
    }
}
