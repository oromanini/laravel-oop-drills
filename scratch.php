<?php

require __DIR__ . '/vendor/autoload.php';

use Oscar\PooPractice\Models\Order;
use Oscar\PooPractice\Services\NoDiscount;
use Oscar\PooPractice\Services\VipDiscount;

$regular = new Order(100.0, new NoDiscount());
$vip = new Order(100.0, new VipDiscount());

echo "Regular: {$regular->total()}" . PHP_EOL;
echo "VIP: {$vip->total()}" . PHP_EOL;
