<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApiController extends Controller
{
    public function index() {
        return response()->json(['data' => Product::with('category')->get()], 200);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'qty' => 'required|integer',
                'category_id' => 'required|exists:category,id',
            ]);

            $validated['user_id'] = Auth::id();
            $product = Product::create($validated);

            return response()->json(['message' => 'Produk berhasil ditambahkan!!', 'data' => $product], 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function show($id) {
        $product = Product::with('category')->find($id);
        if (!$product) return response()->json(['message' => 'Tidak ditemukan'], 404);
        return response()->json(['data' => $product], 200);
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Tidak ditemukan'], 404);

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'category_id' => 'required|exists:category,id',
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $product], 200);
    }

    public function destroy($id) {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Berhasil dihapus'], 200);
        }
        return response()->json(['message' => 'Tidak ditemukan'], 404);
    }
}