<?php

require __DIR__ . '/vendor/autoload.php';

use Oscar\PooPractice\Factories\DiscountRuleFactory;
use Oscar\PooPractice\Http\Controllers\OrderController;
use Oscar\PooPractice\Services\OrderService;

$discountRuleFactory = new DiscountRuleFactory();
$orderService = new OrderService($discountRuleFactory);
$controller = new OrderController($orderService);

echo $controller->store(amount: 100, isVip: true, hasCoupon: true) . PHP_EOL;
