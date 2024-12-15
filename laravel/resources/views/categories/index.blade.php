<x-guest-layout>
    <x-slot name="header">
        Категории и товары
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-semibold mb-6 text-white">Категории и товары</h1>

        <!-- Сетка категорий -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h2>

                    <!-- Отображаем общее количество товаров в категории -->
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Всего товаров: {{ $category->products_with_stock_count }}</p>

                    <!-- Список товаров в категории -->
                    <ul class="mt-4 space-y-4">
                        @foreach ($category->products->take(3) as $product)
                        <!-- Показываем только первые 3 товара -->
                            <li class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                <x-product-card
                                :name="$product->name"
                                :price="$product->price"
                                :quantity="$product->quantity"
                                :id="$product->id"
                                :image="$product->image_url ?? null"
                            />
                            </li>
                        @endforeach
                    </ul>

                    <!-- Кнопка для перехода к полному списку товаров -->
                    @if ($category->products_with_stock_count > 3)

                        <a href="{{ route('category.show', $category->id) }}" class="block text-center  hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300">Посмотреть все товары в категории</a>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-6">
            {{ $categories->links() }}
        </div>


    </div>

</x-guest-layout>
