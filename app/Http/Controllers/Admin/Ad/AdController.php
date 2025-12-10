<?php

namespace App\Http\Controllers\Admin\Ad;

use App\Contracts\Repositories\AdminAdRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\FilterAdminAdsRequest;
use App\Http\Requests\Ad\CreateAdRequest;
use App\Http\Requests\Ad\UpdateAdAdminRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdController extends Controller
{
    public function __construct(protected AdminAdRepositoryInterface $adminAdRepository)
    {}

    public function index(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.index', [
            'ads' => $this->adminAdRepository->getAds(10, 'all', $query->validated()),
        ]);
    }
public function create(): View
{
    return view('ads.admin.create');
}

    public function pending(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.pending', [
            'ads' => $this->adminAdRepository->getAds(10, 'pending', $query->validated()),
        ]);
    }

    public function active(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.active', [
            'ads' => $this->adminAdRepository->getAds(10, 'active', $query->validated()),
        ]);
    }

    public function upcoming(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.upcoming', [
            'ads' => $this->adminAdRepository->getAds(10, 'upcoming', $query->validated()),
        ]);
    }

    public function expired(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.expired', [
            'ads' => $this->adminAdRepository->getAds(10, 'expired', $query->validated()),
        ]);
    }

    public function rejected(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.rejected', [
            'ads' => $this->adminAdRepository->getAds(10, 'rejected', $query->validated()),
        ]);
    }

    public function reported(FilterAdminAdsRequest $query): View
    {
        return view('ads.admin.status.reported', [
            'reportedAds' => $this->adminAdRepository->getReportedAds(10, $query->validated()),
        ]);
    }

    public function reportAd(string $adSlug): View
    {
        return view('ads.admin.report', [
            'reportAd' => $this->adminAdRepository->getReportedAd($adSlug),
        ]);
    }

    public function show(string $adSlug): View
    {
        return view('ads.admin.show', [
            'ad' => $this->adminAdRepository->getAdBySlug($adSlug),
        ]);
    }

    public function edit(string $adSlug): View
    {
        return view('ads.admin.edit', [
            'ad' => $this->adminAdRepository->getAdBySlug($adSlug),
        ]);
    }

    public function update(string $adSlug, UpdateAdAdminRequest $request): RedirectResponse
    {
        $this->adminAdRepository->updateAd($adSlug, $request->validated());

        return redirect()
            ->route('admin.ads.show', $adSlug)
            ->with('success', 'Ad updated successfully.');
    }

    public function destroy(string $adSlug): RedirectResponse
    {
        $this->adminAdRepository->deleteAd($adSlug);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Ad deleted successfully.');
    }

    public function store(CreateAdRequest $request): RedirectResponse
    {
        $this->adminAdRepository->createAsAdmin($request->validated());

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Ad created successfully.');
    }
}
