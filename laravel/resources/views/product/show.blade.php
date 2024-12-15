<x-guest-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Категории и товары</h1>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-4 gap-6 ">
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
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $cat->products_count }} товаров </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>


        <main class="col-span-3">
            <div class="bg-white p-6 rounded-lg shadow  dark:bg-gray-700">


                    <div class="grid grid-cols-1  gap-6">
                        <x-product-card
                        :name="$product->name"
                        :price="$product->price"
                        :quantity="$product->quantity"
                        :id="$product->id"
                        :image="$product->image_url ?? null"
                        />
                    </div>
            </div>
        </main>
    </div>
</x-guest-layout>



