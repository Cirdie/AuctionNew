<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Traits\HasTransactionID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory, HasTransactionID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
  protected $fillable = [
    'ad_id',
    'payer_id',
    'payee_id',
    'bid_id',
    'amount',
    'payment_method',
    'gcash_receipt_path',
    'proof_image',
    'delivery_address',   // <-- REQUIRED
    'txn_id',
    'status',
    'currency',
    'description',

];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'status' => PaymentStatus::class,
    ];

    /**
     * Get the ad that owns the payment.
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get the user that paid for the ad.
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    /**
     * Get the user that receives the payment (seller).
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee_id');
    }

    /**
     * Get the bid that owns the payment.
     */
    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    /**
     * Payment is paid / successful.
     */
    public function paid(): bool
    {
        return $this->status === PaymentStatus::SUCCESS;
    }

    /**
     * Check if payment method is COD.
     */
    public function isCod(): bool
    {
        return $this->payment_method === 'COD';
    }

    /**
     * Check if payment method is GCash.
     */
    public function isGcash(): bool
    {
        return $this->payment_method === 'GCASH';
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::PENDING);
    }

    /**
     * Scope a query to only include failed payments.
     */
    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::FAILED);
    }

    /**
     * Scope a query to only include successful payments.
     */
    public function scopeSuccess(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::SUCCESS);
    }

    public function getReceiptUrlAttribute()
{
    if ($this->gcash_receipt_path) {
        return Storage::url($this->gcash_receipt_path);
    }
    return null;
}
}
