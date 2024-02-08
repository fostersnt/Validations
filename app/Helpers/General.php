<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            } elseif (strtolower($main_directory) == 'storage') {
                $path = storage_path("app/public/$sub_directory");
            } else {
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

    public static function check_file_existence($file_name, $main_directory, $sub_directory)
    {
        if ($file_name != null) {
            if (strtolower($main_directory) == 'public') {
                $fullPath = public_path("$sub_directory/$file_name");
                return file_exists($fullPath) && is_file($fullPath);
            }
            elseif (strtolower($main_directory) == 'storage') {
                $fullPath = storage_path("app/public/$sub_directory/$file_name");
                return file_exists($fullPath) && is_file($fullPath);
            }
            else {
                return false;
            }
        }
    }

    public static function move_file($my_file_name, $source_directory, $destination_directory)
    {
        //main_directory is the main directory where you want the file to be moved to.

        try {
            //This line returns true if the file exists in the
            $check_public = self::check_file_existence($my_file_name, 'public', $source_directory);
            $check_storage = self::check_file_existence($my_file_name, 'storage', $source_directory);

            if ($check_public) {
                $source = public_path("$source_directory/$my_file_name");
                $destination = public_path("$destination_directory/$my_file_name");
                Storage::move($source, $destination);
                return true;
            } elseif ($check_storage) {
                $source = storage_path("app/public/$source_directory/$my_file_name");
                $destination = "public/$destination_directory";
                Log::channel('file_upload')->info("\nDESTINATION: " . $destination);
                Storage::move($source, $destination);
                return true;
            } else {
                Log::channel('file_upload')->info("\nFAILED TO MOVE THE FILE: $my_file_name");
                return false;
            }
        } catch (\Throwable $th) {
            Log::channel('file_upload')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
            return false;
        }
    }
}
