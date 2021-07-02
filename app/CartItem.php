<?php

namespace App;

class CartItem
{
    /** @var int */
    public $amount;

    /** @var int */
    public $discountPercent;

    /** @var string */
    public $discountDescription;

    /** @var int */
    public $id;

    public function __construct(
        int $id,
        int $amount,
        int $discountPercent,
        string $discountDescription
    )
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->discountPercent = $discountPercent;
        $this->discountDescription = $discountDescription;
    }
}