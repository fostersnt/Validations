<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class General
{
    public static function addNumbers($a, $b)
    {
        return $a + $b;
    }

    public static function sanitize_input($text)
    {
        // $data = trim($text);
        $data = stripslashes($text);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function validate_phone_number($phoneNumber)
    {
        //Remove unnecessary characters from the phone number
        $phoneNumber = self::sanitize_input($phoneNumber);

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

    public static function does_not_contain_space($string_value)
    {
        // Check if the string contains any space
        if (strpos($string_value, ' ') !== false) {
            // return 'Contain space';
            return false; // String contains space, return false
        } else {
            // return 'Does not contain space';
            return true;
        }
    }

    public static function contains_only_alphabets($inputString)
    {
        if (ctype_alpha($inputString)) {
            return true;
        }
        return false;
    }

    public static function store_file($file, $main_directory, $sub_directory)
    {
        try {
            $file_original_name = $file->getClientOriginalName();

            if (strtolower($main_directory) == 'public') {
                $path = public_path($sub_directory);
            }
            elseif (strtolower($main_directory) == 'storage') {
                $path = storage_path("app/public/$sub_directory");
            }
            else {
                $path = '';
            }
            $file_custom_name = time() . '_' . Str::random(8) . '_' . str_replace([' ', '-'], '_', $file_original_name);
            $file->move($path, $file_custom_name);

            return [
                'file_name' => $file_custom_name,
                'status' => 'success',
            ];
        } catch (\Throwable $th) {
            Log::channel('product')->error("ERROR MESSAGE: " . $th->getMessage());
            return [
                'file_name' => null,
                'status' => 'failed',
            ];
        }
    }

    public function storage_path_existence($file_name, $sub_directory)
    {
        if ($file_name != null) {
            $fullPath = storage_path("app/public/$sub_directory/$file_name");
            return file_exists($fullPath) && is_file($fullPath);
        }
    }

    public function public_path_existence($file_name, $sub_directory)
    {
        if ($file_name != null) {
            $fullPath = public_path("$sub_directory/$file_name");
            return file_exists($fullPath) && is_file($fullPath);
        }
    }
}
