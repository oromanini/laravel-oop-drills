<?php

require __DIR__ . '/vendor/autoload.php';

use Oscar\PooPractice\Factories\DiscountRuleFactory;
use Oscar\PooPractice\Http\Controllers\OrderController;
use Oscar\PooPractice\Services\OrderService;
use Oscar\PooPractice\Services\ReportExporter;
use Oscar\PooPractice\Strategies\Export\CsvExportStrategy;
use Oscar\PooPractice\Strategies\Export\JsonExportStrategy;
use Oscar\PooPractice\Strategies\Export\PdfExportStrategy;
use Oscar\PooPractice\Strategies\Export\XmlExportStrategy;

//$discountRuleFactory = new DiscountRuleFactory();
//$orderService = new OrderService($discountRuleFactory);
//$controller = new OrderController($orderService);
//
//echo $controller->store(amount: 100, isVip: true, hasCoupon: true) . PHP_EOL;

//$xmlStrategy = new XmlExportStrategy();
//$xml = $xmlStrategy->export([]);
//echo $xml;

$reportExporter = new ReportExporter([
    'xml' => new XmlExportStrategy(),
    'pdf' => new PdfExportStrategy(),
    'csv' => new CsvExportStrategy(),
    'json' => new JsonExportStrategy(),
]);

echo $reportExporter->export(['name' => 'Oscar'], 'xxx');