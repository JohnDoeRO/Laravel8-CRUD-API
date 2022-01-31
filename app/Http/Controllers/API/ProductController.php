<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $result = Product::latest()->get();
        if($request->category) {
            $result = $result->where('product_category', $request->category);
        };
        return response()->json([ProductResource::collection($result)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'category' => 'required|string|max:50',
            'price' => 'numeric|min:0.01'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $product = Product::create([
            'product_name' => $request->name,
            'product_desc' => $request->description,
            'product_category' => $request->category,
            'product_price' => $request->price,
         ]);

        return response()->json(['Product created successfully.', new ProductResource($product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json('Product not found', 404);
        }
        return response()->json([new ProductResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:250',
            'category' => 'string|max:50',
            'price' => 'numeric|min:0.01'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $product->product_name = $request->name;
        $product->product_desc = $request->description;
        $product->product_category = $request->category;
        $product->product_price = $request->price;
        $product->save();

        return response()->json(['Product updated successfully.', new ProductResource($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json('Product deleted successfully');
    }
}
