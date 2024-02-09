<?php

namespace App\Helpers;

use App\Models\TemporalFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class General
{
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
        // if ($file->extension() == 'png') {
        Log::info("\nEXTENSION IS: " . $file
            ->extension());
        // }
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
            } elseif (strtolower($main_directory) == 'storage') {
                $fullPath = storage_path("app/public/$sub_directory/$file_name");
                return file_exists($fullPath) && is_file($fullPath);
            } else {
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

    public static function convert_excel_date_using_php_spreadsheet($excelDateValue)
    {
        try {
            $timestamp = Date::excelToTimestamp($excelDateValue);
            // $humanReadableDate = date('Y-m-d H:i:s', $timestamp);
            $humanReadableDate = date('Y-m-d', $timestamp);
            return $humanReadableDate;
        } catch (\Throwable $th) {
            Log::info("\nATTEMPT TO CONVERT EXCEL DATE USING PHP SPREADSHEET: " . $th->getMessage());
            return null;
        }
    }

    public static function read_excel_file($file_id)
    {
        $my_cell_values = [];
        $my_cells = [];
        $issues = [];
        $names = [];

        try {
            $excel_file = TemporalFile::query()->find($file_id);

            $file_path = '';
            $exists = false;

            if ($excel_file == null) {
                return [
                    'success' => false,
                    'message' => "There is no file that matches the file id you provided",
                ];
            }

            $exists = General::check_file_existence($excel_file->file_name, 'storage', 'Product_Image');

            if ($excel_file != null && $exists) {
                $file_path = storage_path("app/public/Product_Image/$excel_file->file_name");
            }

            /** Identify the type of $inputFileName **/
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_path);

            /** Create a new Reader of the type that has been identified **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

            /** Load $inputFileName to a Spreadsheet Object **/
            $spreadsheet = $reader->load($file_path);

            /** Get all sheet names **/
            $sheetNames = $spreadsheet->getSheetNames();

            /** Loop through each sheet **/
            foreach ($sheetNames as $sheetName) {
                /** Get the worksheet by name **/
                $worksheet = $spreadsheet->getSheetByName($sheetName);

                /** Output the sheet name **/
                // echo "Sheet Name: $sheetName" . PHP_EOL;

                /** Loop through rows and cells in the sheet **/
                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    // $rr = $row->getRO
                    if ($row->getRowIndex() >= 2) {
                        $first_name = $worksheet->getCell('A' . $row->getRowIndex())->getValue();
                        $last_name = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
                        $age = $worksheet->getCell('C' . $row->getRowIndex())->getValue();
                        $date_of_birth = $worksheet->getCell('D' . $row->getRowIndex())->getValue();

                        $null_check = $first_name != null && $last_name != null && $age != null && $date_of_birth != null;

                        if ($null_check) {
                            $new_date_of_birth = self::convert_excel_date_using_php_spreadsheet($date_of_birth);
                            array_push($names, [$first_name, $last_name, $age, $new_date_of_birth]);
                        }
                    }

                    $cellIterator->setIterateOnlyExistingCells(false);

                    // foreach ($cellIterator as $cell) {
                    //     // echo $cell->getValue() . "\t";
                    //     array_push($my_cell_values, $cell->getValue());
                    //     array_push($my_cells, $cell->getCoordinate());
                    //     if ($cell->getValue() == null) {
                    //         array_push($issues, "Resolve the issue in Cell " . $cell->getCoordinate() . " at Row " . $row->getRowIndex());
                    //     }
                    // }
                }
            }
            Log::info("\nEXCEL DATA: " . json_encode($my_cell_values));
            return [
                'success' => true,
                'cells' => $my_cells,
                'cell_values' => $my_cell_values,
                'issues' => $issues,
                'names' => $names
            ];
        } catch (\Throwable $th) {
            Log::channel('excel_reading')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
