<x-guest-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Категории и товары</h1>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-4 gap-6">
        <!-- Боковое меню с категориями -->
        <aside class="col-span-1">
            <div class="bg-white p-4 rounded-lg shadow dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Категории</h2>
                <ul class="space-y-2">
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat->id) }}"
                               class="block p-2 rounded-lg text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700
                               {{ $cat->id === $category->id ? 'bg-gray-100 dark:bg-gray-700 font-bold' : '' }}">
                                {{ $cat->name }}
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $cat->products_with_stock_count }} товаров </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Продукты выбранной категории -->
        <main class="col-span-3">
            <div class="bg-white p-6 rounded-lg shadow  dark:bg-gray-700 ">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Товары в категории: {{ $category->name }}</h2>

                @if ($products->count() > 0)
                    <!-- Список товаров -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ">
                        @foreach ($products as $product)

                        <x-product-card
                        :name="$product->name"
                        :price="$product->price"
                        :quantity="$product->quantity"
                        :id="$product->id"
                        :image="$product->image_url ?? null"
                    />
                        @endforeach
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400">В этой категории пока нет товаров.</p>
                @endif
            </div>
        </main>
    </div>
</x-guest-layout>
