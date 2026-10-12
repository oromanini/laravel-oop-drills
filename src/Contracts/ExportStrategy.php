<?php

namespace Oscar\PooPractice\Contracts;

interface ExportStrategy
{
    public function export(array $data): string;
}