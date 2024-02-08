<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilePondProcessingController extends Controller
{
    public function process_file(Request $request)
    {
        try {
            $result = General::store_file($request->image, 'storage', 'Temporal_Files');
            if ($result['file_name'] != null) {
                return response()->json([
                    'message' => 'success',
                    'file_name' => $result['file_name'],
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'file_name' => $result['file_name'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::channel('file_upload')->error("\nERROR MESSAGE: " . $th->getMessage());
            return response()->json([
                'message' => 'Error occurred while processing file',
                'file_name' => null,
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
