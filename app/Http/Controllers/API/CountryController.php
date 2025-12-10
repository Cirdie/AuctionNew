<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    public function __construct(
        protected CountryRepositoryInterface $countryRepository
    ) {}

    /**
     * Get all PH Provinces
     */
    public function getStates(string $iso2code): JsonResponse
    {
        if (strtoupper($iso2code) !== 'PH') {
            return response()->json([
                'success' => false,
                'message' => 'Only Philippines (PH) is supported.',
                'data' => [],
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Provinces loaded.',
            'data' => $this->countryRepository->provinces(),
        ]);
    }

    /**
     * Get all Cities / Municipalities under a Province
     */
    public function getCities(string $iso2code, string $provinceCode): JsonResponse
    {
        if (strtoupper($iso2code) !== 'PH') {
            return response()->json([
                'success' => false,
                'message' => 'Only Philippines (PH) is supported.',
                'data' => [],
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cities loaded.',
            'data' => $this->countryRepository->cities($provinceCode),
        ]);
    }

    /**
     * Get all Barangays under a City / Municipality
     */
    public function getBarangays(string $cityCode): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Barangays loaded.',
            'data' => $this->countryRepository->barangays($cityCode),
        ]);
    }
}
