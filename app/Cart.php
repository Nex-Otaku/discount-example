<?php

namespace App;

class Cart
{
    /** @var array */
    private $items;

    public function __construct(
        array $items
    )
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}