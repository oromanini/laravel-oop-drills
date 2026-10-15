<?php

namespace Oscar\PooPractice\Container;

use Closure;
use RuntimeException;

class Container
{
    private array $recipes = [];

    public function bind(string $abstract, Closure $factory): void
    {
        $this->recipes[$abstract] = $factory;
    }

    public function make(string $abstract): object
    {
        if (!isset($this->recipes[$abstract])) {
            throw new RuntimeException("No binding registered for {$abstract}");
        }

        return $this->recipes[$abstract]();
    }
}