<?php

namespace Oscar\PooPractice\Strategies\Export;

use Oscar\PooPractice\Contracts\ExportStrategy;

class PdfExportStrategy implements ExportStrategy
{

    public function export(array $data): string
    {
        $pdf = '';

        foreach ($data as $item => $value) {
            $pdf .= "{$item} => {$value}" . PHP_EOL;
        }

        return $pdf;
    }
}