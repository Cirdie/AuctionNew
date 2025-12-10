<?php

namespace App\Repositories\Bid\Admin;

use App\Abstracts\BaseCrudRepository;
use App\Models\Bid;
use App\Contracts\Repositories\AdminBidRepositoryInterface;
use App\Enums\AdStatus;
use App\Enums\PriceRange;
use App\Exceptions\BidCustomException;
use App\Exceptions\BidException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Notifications\Bid\BidAcceptedNotification;
use App\Notifications\Bid\BidRejectedNotification;
use App\Repositories\Ad\User\AdRepository;

class AdminBidRepository extends BaseCrudRepository implements AdminBidRepositoryInterface
{
    public function __construct(Bid $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all bids
     */
    public function getBids(int $limit = 10, array $filters = null): LengthAwarePaginator
    {
        return $this->model->query()->with(['ad:id,slug,price,title', 'user:id,name,avatar,username'])
            ->when($filters, function ($query) use ($filters) {
                $query->when(isset($filters['accepted']), function ($query) use ($filters) {
                    $query->where('is_accepted', $filters['accepted'] === 'accepted' ? true : ($filters['accepted'] === 'rejected' ? false : null));
                })
                ->when(isset($filters['price_range']), function ($query) use ($filters) {
                    $query->whereBetween('amount', PriceRange::range($filters['price_range']));
                })
                ->when(isset($filters['date_from']) && isset($filters['date_to']), function ($query) use ($filters) {
                    $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
                })
                ->when(isset($filters['bid_id']), function ($query) use ($filters) {
                    $query->where('id', $filters['bid_id'])
                          ->orWhere('user_id', $filters['bid_id']);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit)
            ->appends([
                'accepted' => $filters['accepted'] ?? null,
                'price_range' => $filters['price_range'] ?? null,
                'date_from' => $filters['date_from'] ?? null,
                'date_to' => $filters['date_to'] ?? null,
                'bid_id' => $filters['bid_id'] ?? null,
            ]);
    }

    /**
     * Get bid by id
     */
    public function getBid(string $id): Bid
    {
        return $this->model->with(['ad:id,slug,price,title', 'user:id,name,avatar,username'])
            ->where('id', $id)
            ->firstOr(function () {
                throw new BidCustomException('Bid not found.');
            });
    }

    /**
     * ADMIN – Accept Bid
     */
    public function acceptBid(string $adSlug, string $bidId): void
    {
        // Load ad
        $ad = app(AdRepository::class)->findBy('slug', $adSlug, function () {
            throw new BidCustomException('Ad not found.');
        });

        // Cannot accept if already sold
        if ($ad->hasAcceptedBid()) {
            throw new BidException('This ad already has a winning bid.', $ad->slug, true);
        }

        // Validate bid
        $bid = $this->model->where('id', $bidId)
            ->where('ad_id', $ad->id)
            ->firstOr(function () use ($ad) {
                throw new BidException('Bid not found.', $ad->slug, true);
            });

        // Accept winning bid
        $bid->update(['is_accepted' => true]);

        // Update ad as expired/sold
        $ad->update([
            'status' => AdStatus::EXPIRED,
            'expired_at' => now(),
        ]);
    }
}
