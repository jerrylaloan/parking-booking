<?php

namespace Tests\Unit;

use App\Helpers\TimeUtils;
use PHPUnit\Framework\TestCase;

class TimeUtilsTest extends TestCase
{
    public function getHourDiffsProvider(): array
    {
        return [
            [date_create('2022-03-25 09:00:00'), date_create('2022-03-25 11:00:00'), 2],
            [date_create('2022-03-25 09:00:00'), date_create('2022-03-25 12:50:00'), 4],
            [date_create('2022-03-25 19:00:00'), date_create('2022-03-25 12:50:00'), 7],
        ];
    }

    /**
     * @dataProvider getHourDiffsProvider
     */
    public function test_getHourDiffs($date1, $date2, $expected)
    {
        $result = TimeUtils::getHourDiffs($date1, $date2);

        $this->assertSame($expected, $result);
    }
}
