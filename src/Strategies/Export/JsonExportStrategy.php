<?php

namespace Oscar\PooPractice\Strategies\Export;

use Oscar\PooPractice\Contracts\ExportStrategy;

class JsonExportStrategy implements ExportStrategy
{

    public function export(array $data): string
    {
        return json_encode($data);
    }
}