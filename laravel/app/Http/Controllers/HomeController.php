<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем категории с наибольшим количеством заказов
        $popularCategories = Category::withCount(['products as orders_count' => function ($query) {
            $query->select(DB::raw('SUM(order_product.quantity)'))->join('order_product', 'products.id', '=', 'order_product.product_id');
        }])
        ->orderByDesc('orders_count')
        ->take(6)
        ->get();

        // Получаем популярные товары (с наибольшим количеством заказов)
        $popularProducts = Product::select('products.*')
            ->having('quantity', '>', 0) // Убираем товары, где количество равно 0
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->selectRaw('SUM(order_product.quantity) as total_orders')
            ->groupBy('products.id')
            ->orderByDesc('total_orders')
            ->take(6)
            ->get();

        // Получаем горячие товары (остаток менее 4)
        $hotProducts = Product::where('quantity', '<', 4)
        ->where('quantity', '>', 0)
        ->orderBy('quantity')->take(6)->get();

        // Передаем данные в представление
        return view('welcome', compact('popularCategories', 'popularProducts', 'hotProducts'));
    }
}
