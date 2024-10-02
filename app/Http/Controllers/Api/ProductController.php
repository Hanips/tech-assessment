<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $take = $request->query('take', 10);
        $skip = $request->query('skip', 0);
        $search = $request->query('search', '');
        $includeDeleted = $request->query('include_deleted', false);

        $query = Product::where('name', 'like', "%{$search}%");

        if ($includeDeleted) {
            $query = $query->withTrashed();
        }

        $products = $query->skip($skip)->take($take)->get();

        return response()->json([
            'code' => 200,
            'message' => 'Product list retrieved successfully',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ]);
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'photo' => $request->photo,
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::withTrashed()->find($id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product not found',
                'data' => null
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Product retrieved successfully',
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::withTrashed()->find($id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product not found',
                'data' => null
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'price' => 'numeric|min:0',
            'photo' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ]);
        }

        $product->update($request->all());

        return response()->json([
            'code' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product not found',
                'data' => null
            ]);
        }

        $product->delete(); 

        return response()->json([
            'code' => 200,
            'message' => 'Product deleted successfully',
            'data' => null
        ]);
    }

    public function restore(string $id)
    {
        $product = Product::onlyTrashed()->find($id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product not found or not deleted',
                'data' => null
            ]);
        }

        $product->restore();

        return response()->json([
            'code' => 200,
            'message' => 'Product restored successfully',
            'data' => $product
        ]);
    }

    public function forceDelete(string $id)
    {
        $product = Product::onlyTrashed()->find($id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Product not found',
                'data' => null
            ]);
        }

        $product->forceDelete();

        return response()->json([
            'code' => 200,
            'message' => 'Product permanently deleted',
            'data' => null
        ]);
    }
}
