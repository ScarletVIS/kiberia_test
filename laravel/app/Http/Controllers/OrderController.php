<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Получаем текущего пользователя

        if ($user->is_admin) {
            $orders = Order::paginate(5);
        } else {
            // Получаем заказы пользователя
            $orders = $user->orders()->with('items.product')->latest()->paginate(5);
        }


        return view('orders.index', compact('orders'));
    }

    public function store()
    {

        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Для оформления заказа необходимо войти в аккаунт.'])->with('debug', 'Error passed to session');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->withErrors(['error' => 'Ваша корзина пуста.']);
        }

        $user = auth()->user(); // Получаем текущего пользователя

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        if ($totalAmount > $user->balance) {
            return redirect()->route('cart.view')->withErrors(['error' => 'Недостаточно средств.']);
        }

        // Создаем заказ
        $order = $user->orders()->create(['status' => 'new', 'total' => $totalAmount]);

        foreach ($cart as $id => $item) {
            // Добавляем товары в заказ
            $order->items()->create([
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Уменьшаем количество товара на складе
            $product = Product::findOrFail($id);
            $product->decrement('quantity', $item['quantity']);


        }
        //Списываем бабки
        $user->balance -= $totalAmount;
        $user->save();

        // Очистка корзины
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Заказ успешно создан!');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();

        if ($user->id !== $order->user_id && !$user->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $user = auth()->user();

        if ($user->id !== $order->user_id && !$user->is_admin) {
            abort(403, 'Доступ запрещен');
        }


        if ($order->status === 'canceled') { // не прописано в тз, можно ли отменять подтвержденные заказы или нет

            return redirect()->route('orders.index', ['page' => request('page')])->withErrors(['error' => 'Заказ уже отменен!']);
        }

        // Возвращаем деньги на баланс пользователя
        $client = $order->user;
        if ($client) {
            // Возвращаем деньги на баланс клиента
            $client->balance += $order->total;
            $client->save();
        } else {
            return redirect()->route('orders.index', ['page' => request('page')])->withErrors(['error' => 'Произошла ошибка, клиент не найден!']);
        }

        // Валидация причины
        $request->validate([
            'reason' => 'required|string|min:15|max:255',
        ]);

        // Возвращаем остаток товаров на склад
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
        }

        // Обновляем статус заказа и добавляем причину
        $order->status = 'canceled';
        $order->cancel_reason = $request->reason;
        $order->save();

        return redirect()->route('orders.index', ['page' => request('page')])->with('success', 'Заказ успешно отменен.');
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();

        // Проверяем, что это админ
        if (!$user->is_admin) {
            abort(403, 'У вас нет прав для выполнения этого действия.');
        }

        // Проверяем наличие клиента
        $client = $order->user;
        if (!$client) {
            return redirect()->route('orders.index', ['page' => request('page')])->withErrors(['error' => 'Клиент для этого заказа не найден.']);
        }

        // Проверяем статус заказа
        if ($order->status === 'confirmed') {
            return redirect()->route('orders.index',['page' => request('page')])->withErrors(['error' => 'Этот заказ уже подтвержден.']);
        }

        if ($order->status === 'canceled') {
            // Проверяем баланс клиента
            if ($client->balance < $order->total) {
                return redirect()->route('orders.index', ['page' => request('page')])->withErrors(['error' => 'У клиента недостаточно средств для подтверждения заказа.']);
            }

            // Проверяем наличие товаров на складе
            foreach ($order->items as $item) {
                if ($item->product->quantity < $item->quantity) {
                    return redirect()->route('orders.index',['page' => request('page')])->withErrors(['error' => "Недостаточно товара '{$item->product->name}' на складе."]);
                }
            }

            // Списываем средства с баланса клиента
            $client->balance -= $order->total;
            $client->save();

            // Уменьшаем количество товара на складе
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->quantity -= $item->quantity;
                $product->save();
            }
        }

        // Обновляем статус
        $order->status = 'confirmed';
        $order->save();

        return redirect()->route('orders.index', ['page' => request('page')])->with('success', 'Заказ успешно подтвержден.');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update($request->only('status'));
        return $order;
    }

}
