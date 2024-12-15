@props([
    'name',
    'price',
    'quantity',
    'id',
    'image' => null
])

    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 dark:bg-gray-800 hover:bg-gray-600">

        <!-- Картинка товара -->
        @if ($image ?? false)
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-48 object-cover rounded-t-lg">
        @endif

        <!-- Информация о товаре -->
        <div class="mt-4">
            <a href="{{ route('product.show', $id) ?? '#' }}">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $name }}</h3>

            <p class="text-gray-600 dark:text-gray-400">Цена: <span class="font-semibold">{{ $price }} руб.</span></p>
            <p class="text-gray-600 dark:text-gray-400">Доступно: <span class="font-semibold">{{ $quantity }}</span></p>
        </a>
        </div>

        <!-- Кнопка добавления в корзину -->
        <div class="mt-4">
            <form action="{{ route('cart.add', $id) }}" method="POST">
                @csrf
                <div class="flex items-center space-x-2">
                    <!-- Поле для выбора количества -->
                    <input type="number" name="quantity" min="1" max="{{ $quantity }}" value="1"
                        class="w-16 p-2 border rounded-lg text-center dark:bg-gray-700 dark:text-white" required>

                    <!-- Кнопка добавления в корзину -->
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300">
                        В корзину
                    </button>
                </div>
            </form>
        </div>

    </div>

