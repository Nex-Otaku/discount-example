<?php

namespace App;

class DiscountRule
{
    /** @var int */
    private $percent;

    /** @var string */
    private $description;

    public function __construct(
        int $percent,
        string $description
    )
    {
        $this->percent = $percent;
        $this->description = $description;
    }

    public function getPercent(): int
    {
        return $this->percent;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function canBeApplied(CartItem $item): bool
    {
        return true;
    }
}