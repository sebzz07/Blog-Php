<?php

namespace SebDru\Blog\Global;

class GlobalPost
{
    private ?array $filteredPOST;

    public function __construct()
    {
        $this->filteredPOST = filter_input_array(INPUT_POST) ?? null;
    }

    public function getPOST(?string $key = null)
    {
        if (null !== $key) {
            return $this->filteredPOST[$key] ?? null;
        }
        return $this->filteredPOST;
    }
}
