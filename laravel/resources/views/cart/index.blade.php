<x-guest-layout>
    <x-slot name="header">
        Корзина
    </x-slot>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-gray-300">Корзина</h1>

        @if (empty($cart))
            <p class="text-gray-600">Ваша корзина пуста.</p>
        @else
            <table class="w-full text-left border-collapse text-gray-300 ">
                <thead>
                    <tr>
                        <th class="border-b py-2">Товар</th>
                        <th class="border-b py-2">Цена</th>
                        <th class="border-b py-2">Количество</th>
                        <th class="border-b py-2">Итого</th>
                        <th class="border-b py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td class="border-b py-2">{{ $item['name'] }}</td>
                            <td class="border-b py-2">{{ $item['price'] }} руб.</td>
                            <td class="border-b py-2">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        max="{{ $item['stock'] }}"
                                        class="w-16 text-center border rounded text-gray-900"
                                    >
                                    <button
                                        type="submit"
                                        class="ml-2 bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded">
                                        Обновить
                                    </button>
                                </form>
                            </td>
                            <td class="border-b py-2 ">{{ $item['price'] * $item['quantity'] }} руб.</td>
                            <td class="border-b py-2">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-between items-center">
                <p class="text-xl font-bold text-gray-300">
                    Общая сумма:
                    {{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) }} руб.
                </p>
                <form action="{{ route('order.create') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg">
                        Оформить заказ
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-guest-layout>
