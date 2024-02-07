<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //

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
                Product::query()->create([
                    'name' => $request->name,
                ]);
                return back()->with('success', 'Product has been created successfully');
            } catch (\Throwable $th) {
                Log::channel('product')->error("\nERROR MESSAGE: " . $th->getMessage() . "\nLINE NUMBER: " . $th->getLine());
                return back()->with("error", "An error occurred");
            }
        }

    }
}
