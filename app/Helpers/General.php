<?php

namespace App\Helpers;

class General
{
    public static function addNumbers($a, $b)
    {
        return $a + $b;
    }

    public static function validate_phone_number($phoneNumber)
    {
        // Check if the phone number contains any non-digit character
        if (preg_match('/\D/', $phoneNumber)) {
            return false;
        }

        $length = strlen($phoneNumber);
        if ($length === 10) {
            if (preg_match('/^0[25][34567]\d{7}$/', $phoneNumber)) {
                return true;
            }
        } elseif ($length === 12) {
            if (preg_match('/^233[25][34567]\d{7}$/', $phoneNumber)) {
                return true;
            }
        }
        return false;
    }
}
