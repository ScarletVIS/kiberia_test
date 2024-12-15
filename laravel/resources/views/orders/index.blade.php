<x-app-layout>
    <div class="container mx-auto w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg ">

        <h1 class="text-2xl font-bold mb-4 text-gray-300 mt-6">Ваши заказы</h1>

        @if ($orders->isEmpty())
            <p class="text-gray-300">У вас нет заказов.</p>
        @else
            <table class="w-full text-left border-collapse text-gray-300">
                <thead>
                    <tr>
                        <th class="border-b py-2">Номер заказа</th>
                        @if (auth()->user()->is_admin)
                            <th class="border-b py-2">Клиент</th>
                        @endif
                        <th class="border-b py-2">Дата</th>
                        <th class="border-b py-2">Сумма</th>
                        <th class="border-b py-2">Статус</th>
                        <th class="border-b py-2 text-center"></th>
                        <th class="border-b py-2 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="border-b py-2">#{{ $order->id }}</td>
                            @if (auth()->user()->is_admin)
                                <td class="border-b py-2">{{$order->user->name}}</td>
                            @endif
                            <td class="border-b py-2">{{ $order->ordered_at }}</td>
                            <td class="border-b py-2">{{ $order->total }} руб.</td>
                            <td class="border-b py-2">{{ $order->status }}</td>
                            <td class="border-b py-2 text-center">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-indigo-600 hover:underline">
                                    Подробнее
                                </a>
                            </td>
                            <td class="border-b py-2 text-center">
                                @if (auth()->user()->is_admin)
                                    <div class="flex justify-center gap-2 mt-2">
                                        <button
                                            onclick="showCancelModal({{ $order->id }})"
                                            class="group bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg relative">
                                            <i class="fa fa-trash text-2xl text-gray-700 group-hover:text-gray-900 transition duration-100"></i>
                                            <!-- Всплывающая подсказка -->
                                            <span class="absolute bottom-12 -right-2 px-2 py-1 text-xs text-white bg-black rounded-md opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transition duration-300">
                                               Отменить заказ
                                            </span>
                                        </button>
                                        <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ request('page') }}">
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                                Подтвердить
                                            </button>
                                        </form>
                                    </div>
                                @elseif ($order->status === 'new')
                                    <div class="flex justify-center gap-2 mt-2">
                                        <button
                                            onclick="showCancelModal({{ $order->id }})"
                                            class="group bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg relative">
                                            <i class="fa fa-trash text-2xl text-gray-700 group-hover:text-gray-900 transition duration-100"></i>
                                            <!-- Всплывающая подсказка -->
                                            <span class="absolute bottom-12 -right-2 px-2 py-1 text-xs text-white bg-black rounded-md opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transition duration-300">
                                               Отменить заказ
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Пагинация -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Модальное окно для отмены заказа -->
    <div id="cancel-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-11/12 md:w-1/3">
            <h2 class="text-xl font-bold text-gray-300 mb-4">Отмена заказа</h2>
            <form id="cancel-form" method="POST">
                @csrf
                <input type="hidden" name="page" value="{{ request('page') }}">
                <label for="cancel-reason" class="block text-gray-300 mb-2">Причина отмены:</label>
                <textarea id="cancel-reason" name="reason" class="w-full rounded-md bg-gray-700 text-white p-2" rows="3" required></textarea>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeCancelModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Отмена
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Подтвердить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
       function showCancelModal(orderId) {
            const modal = document.getElementById('cancel-modal');
            const form = document.getElementById('cancel-form');
            const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
            form.action = `/orders/${orderId}/cancel?page=${currentPage}`;
            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancel-modal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
