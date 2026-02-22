<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    public function __construct(protected BookingService $bookingService)
    {
    }

    public function calendar(): JsonResponse
    {
        $property = $this->bookingService->getPrimaryProperty();

        if (! $property) {
            return response()->json(['blocked' => [], 'min_advance_days' => BookingService::MIN_ADVANCE_DAYS]);
        }

        $blocked = $this->bookingService->getBlockedDateRanges($property, 18);

        return response()->json([
            'blocked'          => $blocked,
            'min_advance_days' => BookingService::MIN_ADVANCE_DAYS,
            'min_date'         => now()->addDays(BookingService::MIN_ADVANCE_DAYS)->toDateString(),
        ]);
    }
}
