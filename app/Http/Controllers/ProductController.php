<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Jobs\FileUploadJob;
use App\Models\Product;
use App\Models\TemporalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show_create()
    {
        $item = 'God is good';
        return view('welcome', compact('item'));
    }

    public function create_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            // 'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        // dd($request->all());


        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        } else {
            try {
                $outcome = DB::transaction(function () use ($request) {
                    $data['name'] = $request->name;

                    $temp_file = TemporalFile::query()->find($request->temporal_file_id);
                    if ($temp_file != null) {
                        $exists = General::check_file_existence($temp_file->file_name ?? 'Unknown', 'storage', 'Product_Image');
                        if ($exists) {
                            $data['image'] = $temp_file->file_name;
                        } else {
                            return ['error', 'This product does not have image'];
                        }
                    }

                    Product::query()->create($data);
                    $temp_file->delete();

                    return ['success', 'Product has been created successfully'];
                });
                return back()->with($outcome[0], $outcome[1]);
            } catch (\Throwable $th) {
                Log::channel('product')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
                return back()->with("error", "An error occurred");
            }
        }
    }
}
