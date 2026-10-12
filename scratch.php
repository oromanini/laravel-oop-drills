<?php

require __DIR__ . '/vendor/autoload.php';

use Oscar\PooPractice\Models\Order;
use Oscar\PooPractice\Services\BrokenDiscount;
use Oscar\PooPractice\Services\CompositeDiscount;
use Oscar\PooPractice\Services\CouponDiscount;
use Oscar\PooPractice\Services\NoDiscount;
use Oscar\PooPractice\Services\VipDiscount;

//$discountRuleFactory = new DiscountRuleFactory();
//$orderService = new OrderService($discountRuleFactory);
//$controller = new OrderController($orderService);
//
//echo $controller->store(amount: 100, isVip: true, hasCoupon: true) . PHP_EOL;

//$xmlStrategy = new XmlExportStrategy();
//$xml = $xmlStrategy->export([]);
//echo $xml;

//$reportExporter = new ReportExporter([
//    'xml' => new XmlExportStrategy(),
//    'pdf' => new PdfExportStrategy(),
//    'csv' => new CsvExportStrategy(),
//    'json' => new JsonExportStrategy(),
//]);
//
//echo $reportExporter->export(['name' => 'Oscar'], 'pdf');

//$order = new Order(grossAmount: 100, rule: new NoDiscount());
//echo $order->total() . PHP_EOL;

$discountRules = [
    new NoDiscount(),
    new VipDiscount(),
    new CouponDiscount(),
    new BrokenDiscount(),
];

$testValues = [
    0,
    1,
    33.33,
    100,
];

function getStrToFail(mixed $discountRule, float $initialValue, mixed $finalValue): string
{
    return (new ReflectionClass($discountRule))->getShortName()
        . ' = ' . $initialValue . ' => '
        . $finalValue . ' - '
        . 'FAIL' . PHP_EOL;
}

function getStrToPass(mixed $discountRule, float $initialValue, mixed $finalValue): string
{
    return (new ReflectionClass($discountRule))->getShortName()
        . ' = ' . $initialValue . ' => ' .
        $finalValue . ' - '
        . 'PASS' . PHP_EOL;
}

foreach ($testValues as $initialValue){
    foreach ($discountRules as $discountRule) {
        $finalValue = $discountRule->calculate($initialValue);
        if ($finalValue <= $initialValue && $finalValue >= 0) {
            echo getStrToPass($discountRule, $initialValue, $finalValue);
            continue;
        }
        echo getStrToFail($discountRule, $initialValue, $finalValue);
    }
}
