<?php

declare(strict_types=1);

namespace SebDru\Blog\Controller;

class GlobalFilter
{
    private ?array $filteredGlobal;
    private int $paramFilter;

    public function __construct(string $type)
    {
        switch ($type) {
            case 'get':
                $this->paramFilter = INPUT_GET;
                break;
            case 'post':
                $this->paramFilter = INPUT_POST;
                break;
        }
    }

    public function filter(?string $key = null)
    {
        $this->filteredGlobal = filter_input_array($this->paramFilter) ?? null;
        if (null !== $key) {
            return $this->filteredGlobal[$key] ?? null;
        }
        return $this->filteredGlobal;
    }
}
