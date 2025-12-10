<?php

namespace App\Repositories\Country;

use App\Contracts\Repositories\CountryRepositoryInterface;
use Illuminate\Support\Facades\Http;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * Return "all countries" — PH only now
     */
    public function all(): array
    {
        return [
            (object)[
                'iso2'       => 'PH',
                'name'       => 'Philippines',
                'emoji'      => '🇵🇭',
                'phone_code' => '63',
            ],
        ];
    }

    /**
     * Get all PH Provinces (PSGC API)
     */
    public function provinces(): array
    {
        return Http::get("https://psgc.gitlab.io/api/provinces/")->json() ?? [];
    }

    /**
     * Get all Cities/Municipalities under a Province
     */
    public function cities(string $provinceCode): array
    {
        return Http::get(
            "https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/"
        )->json() ?? [];
    }

    /**
     * Get all Barangays under a City/Municipality
     */
    public function barangays(string $cityCode): array
    {
        return Http::get(
            "https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays/"
        )->json() ?? [];
    }
}
