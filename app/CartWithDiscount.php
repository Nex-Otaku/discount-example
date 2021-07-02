<?php

namespace App;

class CartWithDiscount
{
    /** @var array */
    private $items;

    /** @var array */
    private $discountRules;

    public function __construct(
        Cart $cart,
        array $discountRules
    )
    {
        $this->items = $this->applyDiscountRules($cart->getItems(), $discountRules);
        $this->discountRules = $discountRules;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getDiscountRules(): array
    {
        return $this->discountRules;
    }

    /**
     * @param CartItem[] $items
     * @param DiscountRule[] $discountRules
     * @return CartItem[]
     */
    private function applyDiscountRules(array $items, array $discountRules): array
    {
        $result = [];

        foreach ($items as $item) {
            $totalDiscountPercent = 0;
            $totalDiscountDescriptions = [];

            foreach ($discountRules as $discountRule) {
                if (!$discountRule->canBeApplied($item)) {
                    continue;
                }

                $totalDiscountPercent += $discountRule->getPercent();
                $totalDiscountDescriptions []= $discountRule->getDescription();
            }

            $amountDiscounted = $this->calcDiscountedAmount($item->amount, $totalDiscountPercent);
            $finalDesciption = implode('. ', $totalDiscountDescriptions);

            $result [$item->id]= new CartItem($item->id, $amountDiscounted, $totalDiscountPercent, $finalDesciption);
        }

        return $result;
    }

    private function calcDiscountedAmount(int $amount, int $discountPercent): int
    {
        return $amount - (int) (($discountPercent * $amount) / 100);
    }

    public function itemById(int $id): CartItem
    {
        if (!array_key_exists($id, $this->items)) {
            throw new \RuntimeException("Not found item with ID {$id}");
        }

        return $this->items[$id];
    }
}