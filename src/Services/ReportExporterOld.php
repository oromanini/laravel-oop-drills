<?php

namespace Oscar\PooPractice\Services;

class ReportExporterOld
{
    public function export(array $data, string $format): string
    {

        return match ($format) {
            'csv' => implode(',', $data),
//            'xml' => $this->makeXml($data),
            'json' => json_encode($data),
            default => 'Unknown format',
        };
    }


}