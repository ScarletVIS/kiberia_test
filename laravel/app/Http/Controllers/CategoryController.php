<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
    // Получаем все категории с их товарами, фильтруем категории, у которых есть товары
    $categories = Category::whereHas('products', function ($query) {
            $query->where('quantity', '>', 0); // Фильтруем товары с ненулевым количеством
        })
        ->withCount(['products as products_with_stock_count' => function ($query) {
            $query->where('quantity', '>', 0); // Подсчитываем только товары с ненулевым количеством
        }])
        ->having('products_with_stock_count', '>', 0) // Убираем категории без товаров с остатком
        ->orderBy('products_with_stock_count', 'desc') // Сортируем по количеству товаров с остатком
        ->paginate(6);


       // Передаем в представление
       return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:categories']);
        return Category::create($request->only('name'));
    }

    public function show($id)
    {
        // Получаем все категории с их товарами, фильтруем категории, у которых есть товары
        $categories = Category::whereHas('products', function ($query) {
                $query->where('quantity', '>', 0); // Фильтруем товары с ненулевым количеством
            })
            ->withCount(['products as products_with_stock_count' => function ($query) {
                $query->where('quantity', '>', 0); // Подсчитываем только товары с ненулевым количеством
            }])
            ->having('products_with_stock_count', '>', 0) // Убираем категории без товаров с остатком
            ->orderBy('products_with_stock_count', 'desc') // Сортируем по количеству товаров с остатком
            ->get();

        // Получаем выбранную категорию с продуктами (пагинация по 9 товаров)
        $category = Category::with(['products' => function ($query) {
            $query->where('quantity', '>', 0); // Фильтруем продукты с остатком
        }])->findOrFail($id);

        // Пагинация продуктов с остатком
        $products = $category->products()->where('quantity', '>', 0)->paginate(9);

        // Передаем данные в представление
        return view('categories.show', compact('categories', 'category', 'products'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|unique:categories']);
        $category->update($request->only('name'));
        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
