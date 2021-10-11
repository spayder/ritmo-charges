<?php

namespace Tests\Unit;

use App\Presenters\Money;
use PHPUnit\Framework\TestCase;

class MoneyFormatterTest extends TestCase
{
    /** @test */
    public function it_converts_price_into_cents()
    {
        $price = 90;
        $expected = 90000;

        $this->assertEquals($expected, Money::toCents($price));
    }

    /** @test */
    public function it_calculates_price_with_given_discount()
    {
        $original = 100000;
        $discount = 25;

        $this->assertEquals(75000, Money::calculatePriceWithDiscount($original, $discount));
    }
}
