<?php

namespace App\Contracts\Repositories;

interface CountryRepositoryInterface
{
    /**
     * Get all PH Provinces (PSGC)
     *
     * @return array
     */
    public function provinces(): array;

    /**
     * Get all Cities/Municipalities under a Province
     *
     * @param string $provinceCode
     * @return array
     */
    public function cities(string $provinceCode): array;

    /**
     * Get all Barangays under a City/Municipality
     *
     * @param string $cityCode
     * @return array
     */
    public function barangays(string $cityCode): array;
}
