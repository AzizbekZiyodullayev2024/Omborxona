<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class TranslationController extends Controller
{
    public function index(): JsonResponse
    {
        $translations = Translation::with('language')->get();
        return response()->json([
            'status' => 'success',
            'data' => $translations,
            'count' => $translations->count()
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'table_name' => 'required|string|max:255',
            'field_name' => 'required|string|max:255',
            'field_id' => 'required|integer|min:1',
            'field_value' => 'required|string',
            'language_url' => 'required|string|exists:languages,url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $translation = Translation::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Translation created successfully',
                'data' => $translation->load('language')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create translation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $translation = Translation::with('language')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $translation
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Translation not found'
            ], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $translation = Translation::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'table_name' => 'sometimes|string|max:255',
                'field_name' => 'sometimes|string|max:255',
                'field_id' => 'sometimes|integer|min:1',
                'field_value' => 'sometimes|string',
                'language_url' => 'sometimes|string|exists:languages,url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $translation->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Translation updated successfully',
                'data' => $translation->load('language')
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Translation not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update translation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $translation = Translation::findOrFail($id);
            $translation->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Translation deleted successfully'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Translation not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete translation: ' . $e->getMessage()
            ], 500);
        }
    }
}
