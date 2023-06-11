<?php

namespace App\Common;

class Utilities
{
    public static function validateLegalAge($date, $format = 'Y-m-d')
    {
        if (!self::validateDate($date, $format)) {
            return false;
        }
        $dateOfBirth = new \DateTime($date);
        $now = new \DateTime(date($format));

        $diff = $now->diff($dateOfBirth);
        return ($diff->invert && $diff->format("%y") >= 18);
    }

    public static function validateDate($date, $format = 'Y-m-d'):bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function validateDNINIE($value):bool
    {
        $pattern = "/^[XYZ]?\d{5,8}[A-Z]$/";
        $dni = strtoupper($value);
        if(preg_match($pattern, $dni))
        {
            $number = substr($dni, 0, -1);
            $number = str_replace('X', 0, $number);
            $number = str_replace('Y', 1, $number);
            $number = str_replace('Z', 2, $number);
            $dni = substr($dni, -1, 1);
            $start = $number % 23;
            $letter = substr('TRWAGMYFPDXBNJZSQVHLCKET', $start, 1);
            if($letter != $dni)
            {
                return false;
            }
            return true;
        }
        return false;
    }
}
