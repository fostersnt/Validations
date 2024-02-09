<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\TemporalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FilePondProcessingController extends Controller
{
    public function process_file(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:png,jpg,jpeg,xlxs,pdf,xls',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 'failed',
                    'temp_file_id' => null,
                ]);
            }
            try {
            $result = General::store_file($request->image, 'storage', 'Product_Image');
            $exists = General::check_file_existence($result['file_name'], 'storage', 'Product_Image');

            if ($result['file_name'] != null && $exists) {

                $temp = TemporalFile::query()->create([
                    'file_name' => $result['file_name'],
                ]);

                return response()->json([
                    'message' => 'File has been uploaded successfully',
                    'status' => 'success',
                    'temp_file_id' => $temp->id,
                ]);
            } else {
                return response()->json([
                    'message' => 'Product image not found',
                    'status' => 'failed',
                    'temp_file_id' => null,
                ]);
            }
        } catch (\Throwable $th) {
            Log::channel('file_upload')->error("\nERROR MESSAGE: " . $th->getMessage());
            return response()->json([
                'message' => 'Error occurred while processing file',
                'status' => 'failed',
                'temp_file_id' => null,
            ]);
        }
    }

    public function revert_file()
    {

    }

    public function restore_file()
    {

    }

    public function load_file()
    {

    }

    public function fetch_file()
    {

    }
}
