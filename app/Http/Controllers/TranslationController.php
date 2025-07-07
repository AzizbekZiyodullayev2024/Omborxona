<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
{
    public function index()
    {
        return response()->json(Translation::all());
    }

    public function show($id)
    {
        $translation = Translation::find($id);
        if (!$translation) {
            return response()->json(['error' => 'Tarjima topilmadi'], 404);
        }
        return response()->json($translation);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table_name' => 'required|string|max:255',
            'field_name' => 'required|string|max:255',
            'field_id' => 'required|integer',
            'field_value' => 'required|string',
            'language_url' => 'required|string|exists:languages,url'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $translation = Translation::create($request->all());
        return response()->json($translation, 201);
    }

    public function update(Request $request, $id)
    {
        $translation = Translation::find($id);
        if (!$translation) {
            return response()->json(['error' => 'Tarjima topilmadi'], 404);
        }

        $validator = Validator::make($request->all(), [
            'table_name' => 'required|string|max:255',
            'field_name' => 'required|string|max:255',
            'field_id' => 'required|integer',
            'field_value' => 'required|string',
            'language_url' => 'required|string|exists:languages,url'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $translation->update($request->all());
        return response()->json($translation);
    }

    public function destroy($id)
    {
        $translation = Translation::find($id);
        if (!$translation) {
            return response()->json(['error' => 'Tarjima topilmadi'], 404);
        }

        $translation->delete();
        return response()->json(['message' => 'Tarjima muvaffaqiyatli o‘chirildi']);
    }
}
