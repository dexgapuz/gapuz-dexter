<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(private ScheduleService $scheduleService) {}

    public function index(Request $request): JsonResponse
    {
        $date = Carbon::parse($request->query('date'));
        $isOpen = $this->scheduleService->isBakeryOpen($date);
        extract($this->scheduleService->getNextOpenDay($date));

        return response()->json([
            'isOpen' => $isOpen,
            'message' => $isOpen
                ? "The bakery is OPEN! It will next open in $dayUntil days ($dayName)"
                : "Sorry, the bakery is CLOSED. It will open in $dayUntil days ($dayName)."
        ]);
    }
}
