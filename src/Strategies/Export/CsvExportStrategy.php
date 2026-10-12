<?php

namespace Oscar\PooPractice\Strategies\Export;

use Oscar\PooPractice\Contracts\ExportStrategy;

class CsvExportStrategy implements ExportStrategy
{

    public function export(array $data): string
    {
        return implode(',', $data);
    }
}