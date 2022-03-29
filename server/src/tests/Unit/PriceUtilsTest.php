<?php

namespace Tests\Unit;

use App\Helpers\PriceUtils;
use PHPUnit\Framework\TestCase;

class PriceUtilsTest extends TestCase
{
    public function getPriceProvider(): array
    {
        return [
            [0, 0],
            [0.5, 0],
            [1, 0],
            [1.2, 20],
            [1.5, 20],
            [2, 20],
            [2.3, 60],
            [3, 60],
            [3.4, 240],
            [4, 240],
            [4.1, 300],
            [7, 300]
        ];
    }

    /**
     * @dataProvider getPriceProvider
     */
    public function test_getHourDiffs($hour, $expected)
    {
        $result = PriceUtils::getPrice($hour);

        $this->assertSame($expected, $result);
    }
}
