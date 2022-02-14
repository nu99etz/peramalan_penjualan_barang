<?php

class Date {

    public static function isWeekend($date)
    {
        $date = strtotime($date);
        $date = date("l", $date);
        
        if($date == "Sunday") {
            return true;
        }

        return false;
    }

    public static function datediff($date1, $date2)
    {
        $diff = strtotime($date1) - strtotime($date2);

        return abs(round($diff/86400));
    }
}