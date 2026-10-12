<?php

namespace Oscar\PooPractice\Services;

class ReportExporter
{
    public function __construct(private readonly array $strategies)
    {}

    public function export(array $data, string $format): string
    {
        if (isset($this->strategies[$format])) {
            return $this->strategies[$format]->export($data);
        }

        throw new \InvalidArgumentException("Invalid format");
    }
}