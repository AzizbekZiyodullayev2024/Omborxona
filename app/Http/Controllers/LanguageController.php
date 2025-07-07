<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HasFile;
class LanguageController extends Controller
{
    use HasFile;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:languages',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'default' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request, 'image', 'languages');
            if ($imagePath) {
                $data['image'] = $imagePath;
            } else {
                return response()->json(['error' => 'Failed to upload image'], 400);
            }
        }

        $language = Language::create($data);
        return response()->json($language, 201);
    }

    public function index()
    {
        return response()->json(Language::all());
    }

    public function show($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['error' => 'Til topilmadi'], 404);
        }
        return response()->json($language);
    }

    public function update(Request $request, $id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['error' => 'Til topilmadi'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:languages,url,' . $id,
            'image' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'default' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $language->update($request->all());
        return response()->json($language);
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return response()->json(['error' => 'Til topilmadi'], 404);
        }

        $language->delete();
        return response()->json(['message' => 'Til muvaffaqiyatli o‘chirildi']);
    }
}