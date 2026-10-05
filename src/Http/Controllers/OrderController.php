<?php

namespace Oscar\PooPractice\Http\Controllers;

use Oscar\PooPractice\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    ) {}

    public function store(float $amount, bool $isVip, bool $hasCoupon): string
    {
        $total = $this->orderService->calculateTotal($amount, $isVip, $hasCoupon);

        return json_encode([
            'message' => 'Order placed',
            'total' => $total,
            'status' => 200,
        ]);
    }
}
