<?php

namespace SebDru\Blog\Global;

class GlobalGet
{
    private ?array $filteredGET;

    public function __construct()
    {
        $this->filteredGET = filter_input_array(INPUT_GET) ?? null;
    }

    public function getGET(?string $key = null)
    {
        if (null !== $key) {
            return $this->filteredGET[$key] ?? null;
        }
        return $this->filteredGET;
    }
}
