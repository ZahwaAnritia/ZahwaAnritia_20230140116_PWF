<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category; 
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Daftar kategori berhasil diambil',
            'data' => Category::all()
        ], 200);
    }

    public function store(Request $request) {
       
        $validated = $request->validate([
            'name' => 'required|string|unique:category,name'
        ]);

        $category = Category::create($validated);
        
        return response()->json([
            'message' => 'Kategori berhasil dibuat', 
            'data' => $category
        ], 201);
    }

    public function show($id) {
        $category = Category::find($id);
        if ($category) {
            return response()->json(['data' => $category], 200);
        }
        return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        if($category) {
          
            $validated = $request->validate([
                'name' => 'required|string|unique:category,name,' . $id
            ]);

            $category->update($validated);
            return response()->json(['message' => 'Berhasil diupdate', 'data' => $category], 200);
        }
        return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
    }

    public function destroy($id) {
        $category = Category::find($id);
        if($category) {
            $category->delete();
            return response()->json(['message' => 'Berhasil dihapus'], 200);
        }
        return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
    }
}