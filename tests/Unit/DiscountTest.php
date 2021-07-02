<?php

namespace Tests\Unit;

use App\Cart;
use App\CartItem;
use App\CartWithDiscount;
use App\DiscountRule;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    // Оригинальный вариант. Тестируем несколько утверждений.
    public function testOriginal()
    {
        $id = 1;
        $itemWithoutDiscount = new CartItem($id, 611, 0, '');
        $cart = new Cart([$itemWithoutDiscount]);
        $discountRules = [new DiscountRule(10, 'Скидки для привитых')];
        $sut = new CartWithDiscount($cart, $discountRules);

        $item = $sut->itemById($id);

        $this->assertEquals($item->amount, 550);
        $this->assertEquals($item->discountPercent, 10);
        $this->assertEquals($item->discountDescription, 'Скидки для привитых');
    }

    // Предлагаемый вариант. Тестируем по одному утверждению.

    public function testSumForDiscount()
    {
        $originalItem = $this->newItem(611);

        $item = $this->applyDiscount($originalItem, 10, 'Скидки для привитых');

        $this->assertEquals($item->amount, 550);
    }

    public function testPercent()
    {
        $originalItem = $this->newItem(611);

        $item = $this->applyDiscount($originalItem, 10, 'Скидки для привитых');

        $this->assertEquals($item->discountPercent, 10);
    }

    public function testDescription()
    {
        $originalItem = $this->newItem(611);

        $item = $this->applyDiscount($originalItem, 10, 'Скидки для привитых');

        $this->assertEquals($item->discountDescription, 'Скидки для привитых');
    }

    private function newItem(int $amount): CartItem
    {
        return new CartItem(1, $amount, 0, '');
    }

    private function applyDiscount(CartItem $originalItem, int $percent, string $description): CartItem
    {
        $cart = new Cart([$originalItem]);
        $discountRules = [new DiscountRule($percent, $description)];
        $sut = new CartWithDiscount($cart, $discountRules);

        return $sut->itemById($originalItem->id);
    }
}