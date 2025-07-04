<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\FileUploadable;
use App\Traits\HasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use HasFile;
    public function index(): JsonResponse
    {
        try {
            $products = Product::all();
            return response()->json(['data' => $products], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch products'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['data' => $product], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:products,name',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB limit
            ]);

            $data = $validated;
            $data['image_url'] = $this->uploadFile($request, 'image', 'images');

            $product = Product::create($data);
            return response()->json(['message' => 'Mahsulot yaratildi', 'data' => $product], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validatsiya xatosi: ' . json_encode($e->errors()));
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Mahsulot yaratishda xato: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|unique:products,name,' . $id,
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $validated;

            if ($request->hasFile('image')) {
                if ($product->image_url) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_url));
                }
                $path = $request->file('image')->store('images', 'public');
                $data['image_url'] = Storage::url($path);
            }

            $product->update($data);
            return response()->json(['message' => 'Product updated', 'data' => $product], 200);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_url));
            }
            $product->delete();
            return response()->json(['message' => 'Product deleted'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

}
