<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Jobs\FileUploadJob;
use App\Models\Product;
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
            'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        } else {
            try {
                $data['name'] = $request->name;

                if ($request->image != null) {
                    $result = General::store_file($request->image,'storage', 'Product_Image');
                    $data['image'] = $result['file_name'];

                    // I intended to use job/queue for file upload processing but I leter
                    // realized that jobs/queues are not meant to be used for processing files
                    // FileUploadJob::dispatch($request->image, 'Product_Image', 'product', $product->id);
                }
                    Product::query()->create($data);
                return back()->with('success', 'Product has been created successfully');
            } catch (\Throwable $th) {
                Log::channel('product')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
                return back()->with("error", "An error occurred");
            }
        }
    }
}
