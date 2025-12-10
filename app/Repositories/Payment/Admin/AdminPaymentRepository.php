<?php

namespace App\Repositories\Payment\Admin;

use App\Abstracts\BaseCrudRepository;
use App\Models\Payment;
use App\Contracts\Repositories\AdminPaymentRepositoryInterface;
use App\Exceptions\PaymentException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminPaymentRepository extends BaseCrudRepository implements AdminPaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all payments (admin)
     */
    public function getAllPayments(int $limit = 10, string $type = 'all', array $filters = null): LengthAwarePaginator
    {
        return $this->model->query()
            ->with(['payee:id,name,username,avatar', 'payer:id,name,username,avatar', 'ad:id,title'])
            ->when(
                match ($type) {
                    'pending' => fn ($query) => $query->pending(),
                    'failed' => fn ($query) => $query->failed(),
                    'success' => fn ($query) => $query->success(),
                    default => fn ($query) => $query,
                }
            )
            ->when($filters, function ($query) use ($filters) {
                $query->when(isset($filters['search']), function ($query) use ($filters) {
                    $query->where('txn_id', $filters['search'])
                        ->orWhereHas('payer', fn ($q) => $q->where('name', 'like', '%' . $filters['search'] . '%'));
                });

                $query->when(isset($filters['date_from']) && isset($filters['date_to']), function ($query) use ($filters) {
                    $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Get one payment by transaction ID
     */
    public function getPayment(string $txnId): Payment
    {
        return $this->model->query()
            ->with(['payee:id,name,username,avatar', 'payer:id,name,username,avatar', 'ad', 'bid'])
            ->where('txn_id', $txnId)
            ->firstOr(function () {
                throw new PaymentException('Payment not found.');
            });
    }

    /**
     * Admin manually updates payment status
     */
    public function updatePaymentStatus(string $txnId, string $status): void
    {
        $payment = $this->model->where('txn_id', $txnId)->first();

        if (!$payment) {
            throw new PaymentException('Payment not found.');
        }

        $payment->update([
            'status' => $status,
        ]);
    }
}
