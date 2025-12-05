<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ __('Tempahan Saya') }}</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('Lihat dan urus tempahan aktiviti anda.') }}</p>
            </div>

            @if(isset($error))
                <div class="rounded-md bg-red-50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">{{ __('Ralat') }}</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ $error }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($bookings->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Tiada tempahan ditemui') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Anda belum membuat sebarang tempahan.') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('activities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Terokai Aktiviti') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aktiviti') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tarikh & Masa') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Peserta') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tindakan') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $booking->activity_details['name'] ?? __('Tiada') }}
                                                    </div>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $booking->activity_details['location'] ?? __('Tiada') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $booking->booking_date->format('F j, Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $booking->participants }} {{ $booking->participants === 1 ? __('orang') : __('orang') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($booking->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        {{ __('Tertunda') }}
                                                    </span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ __('Disahkan') }}
                                                    </span>
                                                @elseif($booking->status === 'completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ __('Selesai') }}
                                                    </span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ __('Dibatalkan') }}
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                RM{{ number_format($booking->total_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="text-yellow-500 hover:text-yellow-600">{{ __('Lihat') }}</a>

                                                @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                                    <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('{{ __('Adakah anda pasti mahu membatalkan tempahan ini?') }}');">
                                                        @csrf
                                                        <input type="hidden" name="cancelation_reason" value="Customer requested cancellation">
                                                        <button type="submit" class="text-red-500 hover:text-red-600">{{ __('Batal') }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
