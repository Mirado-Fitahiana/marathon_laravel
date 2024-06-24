<?php

namespace App;
use Carbon\Carbon;

class Fonction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function convertStringArrayToTime($times) {
        $valiny = [];

        for ($i = 0; $i < count($times); $i++) {
            $timeString = trim($times[$i]);
            $valiny[$i] = Carbon::createFromFormat('H:i:s', $timeString);
        }
        return $valiny;
    }
    
    public static function calculDifferenceEntreTime($time1,$time2){
        $time1 = Carbon::createFromFormat('H:i:s', $time1);
        // $time2 = Carbon::createFromFormat('H:i:s', $time2);
        return $time1->diff($time2);
    }

    public static function convertDate($date){
        return Carbon::parse($date);
    }

    
}
