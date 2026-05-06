<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        
        $products = Product::with('user')->get();
        return view('product.index', compact('products'));
    }
    public function create() {
    Gate::authorize('manage-product'); 
    $users = User::orderBy('name')->get();
    $categories = \App\Models\Category::all(); 
    

    return view('product.create', compact('categories', 'users'));

}

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        try{ 
            product::create($validated);
            return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
           
            Log::error('Product store database error', ['message' => $e->getMessage()]);
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Database error while creating product.');
        }  catch (\Throwable $e) {
        
            Log::error('Product store unexpected error', ['message' => $e->getMessage()]);
            return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Unexpected error occurred.');
        }
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = User::orderBy('name')->get();
        $categories = \App\Models\Category::all(); 
        return view('product.edit', compact('product', 'users', 'categories'));
    }

   public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0', 
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
            'user_id' => 'required|exists:user,id'
        ]);

        try {
            $product->update($validated);
            return redirect()->route('product.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk.');
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product); 
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}