<?php
namespace App\Helpers;

class Helpers
{
    public static function dateFormat($date)
    {
        return date("Y-m-d",strtotime($date));
    }
    public static function crrrentDateTime()
    {
        return date("Y-m-d H:i:s");
    }
}