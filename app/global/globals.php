<?php

namespace SebDru\Blog\Global;

class Globals
{
    private ?array $GET;
    private ?array $POST;

    public function __contruct()
    {
        $this->GET = filter_input_array(INPUT_GET) ?? null;
        $this->POST = filter_input_array(INPUT_POST) ?? null;
    }

    public function getGET(?string $key = null)
    {
        if (null !== $key) {
            return $this->GET[$key] ?? null;
        }
        return $this->GET;
    }

    public function getPOST(?string $key = null)
    {
        if (null !== $key) {
            return $this->POST[$key] ?? null;
        }
        return $this->POST;
    }
}
