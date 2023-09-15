<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve and return a list of products with their associated categories
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
        // Validate the incoming request data using the defined ProductRequest rules
        $validator = Validator::make($request->all(), $request->rules());

        // If validation fails, return a JSON response with validation error messages
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create a new product using the request data and return a success response
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
            // Load the associated category and return the product details
            $product->load('category');

            return response()->json([
                'status' => 'success',
                'data' => $product,
            ]);
        } catch (\Throwable $e) {
            // Handle any errors that may occur during the process and return an error response
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
        // Validate the incoming request data using the defined ProductRequest rules
        $validator = Validator::make($request->all(), $request->rules());

        // If validation fails, return a JSON response with validation error messages
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Update the product with the request data and return a success response
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
            // Delete the specified product and return a success response
            $product->delete();

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            // Handle any errors that may occur during the process and return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting the product',
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
