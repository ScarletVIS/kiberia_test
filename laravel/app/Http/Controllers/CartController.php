<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function view()
    {
        // Получаем корзину из сессии
        $cart = session()->get('cart', []);

        // Проверяем, есть ли товары в корзине
        if (empty($cart)) {
            $message = 'Ваша корзина пуста.';
            return view('cart.index', compact('cart', 'message'));
        }

        // Подсчитываем общую сумму товаров
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Передаем данные в представление
        return view('cart.index', compact('cart', 'total'));
    }


    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Проверяем доступное количество
        $quantity = $request->input('quantity');

        // Получаем корзину из сессии
        $cart = session()->get('cart', []);

        // Суммируем количество товара, который уже есть в корзине
        $existingQuantity = 0;
        if (isset($cart[$id])) {
            $existingQuantity += $cart[$id]['quantity'];
        }

        // Проверяем доступное количество с учетом уже добавленных товаров
        if ($quantity + $existingQuantity > $product->quantity) {
            return back()->withErrors(['error' => 'Недостаточное количество товара на складе.']);
        }

        // Если товар уже в корзине, увеличиваем количество
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'stock' => $product->quantity,
            ];
        }

        // Сохраняем корзину в сессии
        session()->put('cart', $cart);

        return back()->with('success', 'Товар добавлен в корзину!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = (int)$request->input('quantity', 1);
            $cart[$id]['quantity'] = min($quantity, $cart[$id]['stock']); // Учитываем остаток
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Количество товара обновлено.');
    }


    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Товар удалён из корзины.');
    }
}
