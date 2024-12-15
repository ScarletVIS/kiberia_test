<x-app-layout>

    <div class="container mx-auto w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg text-gray-300">
        <h1 class="text-2xl font-bold mb-4">Детали заказа №{{ $order->id }}</h1>

        <p><strong>Дата:</strong> {{ $order->ordered_at}}</p>
        <p><strong>Сумма:</strong> {{ $order->total }} руб.</p>
        <p><strong>Статус:</strong> {{ $order->status }}</p>

        <h2 class="text-xl font-bold mt-4 mb-2">Товары</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b py-2">Название</th>
                    <th class="border-b py-2">Количество</th>
                    <th class="border-b py-2">Цена</th>
                    <th class="border-b py-2">Итого</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="border-b py-2">{{ $item->product->name }}</td>
                        <td class="border-b py-2">{{ $item->quantity }}</td>
                        <td class="border-b py-2">{{ $item->price }} руб.</td>
                        <td class="border-b py-2">{{ $item->price * $item->quantity }} руб.</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
