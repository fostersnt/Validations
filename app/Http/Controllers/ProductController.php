<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Jobs\FileUploadJob;
use App\Models\Product;
use App\Models\TemporalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show_create()
    {
        return view('welcome');
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
                $data['name'] = $request->name;
                // $moving_file = General::move_file($request->image_name, 'Temporal_Files', 'Product_Image');
                $temp_file = TemporalFile::query()->find($request->temporal_file_id);
                if ($temp_file != null) {
                $exists = General::check_file_existence($temp_file->file_name ?? 'Unknown', 'storage', 'Product_Image');
                if ($exists) {
                    $data['image'] = $temp_file->file_name;
                } else {
                    return back()->with('error', 'This product does not have image');
                }

                }
                // if ($request->image != null) {
                //     $result = General::store_file($request->image,'storage', 'Product_Image');
                //     $data['image'] = $result['file_name'];

                //     // I intended to use job/queue for file upload processing but I leter
                //     // realized that jobs/queues are not meant to be used for processing files
                //     // FileUploadJob::dispatch($request->image, 'Product_Image', 'product', $product->id);
                // }
                    Product::query()->create($data);
                return back()->with('success', 'Product has been created successfully');
            } catch (\Throwable $th) {
                Log::channel('product')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
                return back()->with("error", "An error occurred");
            }
        }
    }
}
