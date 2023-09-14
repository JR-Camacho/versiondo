<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::with('category')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = Product::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product,
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            $product->load('category');
            
            return response()->json([
                'status' => 'success',
                'data' => $product,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error obtaining the product',
                'error' => $e->getMessage(), 
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            
            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting the product',
                'error' => $e->getMessage(), 
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }
}
