<x-guest-layout>

    <!-- Контент -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-12">
        <!-- Популярные категории -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Популярные категории</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($popularCategories as $category)
                    <div class="bg-gray-100 p-6 rounded-lg shadow dark:bg-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $category->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Заказано товаров: {{ $category->orders_count ?? 0 }}</p>
                        <a href="{{ route('category.show', $category->id) }}" class="block text-center  hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300">
                            Посмотреть товары
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Популярные товары -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Популярные товары</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($popularProducts as $product)
                    <div class="p-6 rounded-lg shadow dark:bg-gray-700">
                        <x-product-card
                        :name="$product->name"
                        :price="$product->price"
                        :quantity="$product->quantity"
                        :id="$product->id"
                        :image="$product->image_url ?? null"
                    />
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Горячие товары -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Горячие товары. Скоро закончатся! Успей купить!</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($hotProducts as $product)
                <div class="bg-red-100 p-6 rounded-lg shadow dark:bg-red-500">
                <x-product-card
                :name="$product->name"
                :price="$product->price"
                :quantity="$product->quantity"
                :id="$product->id"
                :image="$product->image_url ?? null"
            />

                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-guest-layout>
