<?php

namespace App\Helpers;

class PriceUtils 
{
    /**
     * Calculate price based on duration of booking
     * 
     * @param  integer $hour - duration of booking hour
     * 
     * @return integer 
     */
    public static function getPrice($hour = 0)
    {
        if (is_numeric($hour) && $hour >= 0 && $hour <= 1) {
            return 0;
        } elseif (is_numeric($hour) && $hour > 1 && $hour <= 2) {
            return 20;
        } elseif (is_numeric($hour) && $hour > 2 && $hour <= 3) {
            return 60;
        } elseif (is_numeric($hour) && $hour > 3 && $hour <= 4) {
            return 240;
        }
        
        return 300;
    }
}
