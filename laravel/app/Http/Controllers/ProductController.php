<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        return Product::create($request->all());
    }

    public function show($id)
    {
        // Получаем все категории с их товарами, фильтруем категории, у которых есть товары
        $categories = Category::withCount('products') // Подсчитываем количество продуктов в каждой категории
                                ->orderBy('products_count', 'desc') // Сортируем по количеству продуктов в убывающем порядке
                                ->get();

        $product = Product::with('category')->findOrFail($id);

        $category = Category::findOrFail($product->category_id);
        return view('product.show', compact('product', 'category', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'exists:categories,id',
            'name' => 'string',
            'price' => 'numeric|min:0',
            'quantity' => 'integer|min:0',
        ]);

        $product->update($request->all());
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}

