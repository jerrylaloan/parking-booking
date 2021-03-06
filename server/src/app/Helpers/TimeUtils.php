<?php

namespace App\Helpers;

class TimeUtils 
{
    /**
     * Calculate diff between 2 dates
     * 
     * @param  datetime $date1
     * @param  datetime $date2
     * 
     * @return float 
     */
    public static function getHourDiffs($date1, $date2) 
    {
        $seconds = strtotime($date2->format('Y-m-d H:i:s')) - strtotime($date1->format('Y-m-d H:i:s'));
        $hours = $seconds / 60 / 60;
        return abs(round($hours, 2)); // return value is float
    }
}
