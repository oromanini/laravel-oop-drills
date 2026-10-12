<?php

namespace Oscar\PooPractice\Strategies\Export;

use Oscar\PooPractice\Contracts\ExportStrategy;

class XmlExportStrategy implements ExportStrategy
{

    public function export(array $data): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
            . '<report>' . PHP_EOL
            . $this->makeXml($data) . PHP_EOL
            . '</report>' . PHP_EOL;
    }

    private function makeXml(array $data): string
    {
        $formattedReportData = '';

        foreach ($data as $key => $value) {
            $formattedReportData .= "<{$key}> {$value} </{$key}>";
        }

        return $formattedReportData;
    }
}