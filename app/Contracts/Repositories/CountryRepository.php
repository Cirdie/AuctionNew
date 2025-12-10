<?php

namespace App\Repositories;

use App\Contracts\Repositories\CountryRepositoryInterface;
use Illuminate\Support\Facades\Http;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * Get all PH provinces (PSGC)
     */
    public function provinces(): array
    {
        return Http::get("https://psgc.gitlab.io/api/provinces/")->json();
    }

    /**
     * Get PH cities/municipalities under a province
     */
    public function cities(string $provinceCode): array
    {
        return Http::get(
            "https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/"
        )->json();
    }

    /**
     * Get barangays under a city/municipality
     */
    public function barangays(string $cityCode): array
    {
        return Http::get(
            "https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays/"
        )->json();
    }
}
