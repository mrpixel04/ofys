@extends('layouts.simple-app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full">
        <div class="text-center mb-8 space-y-3">
            <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 tracking-widest uppercase">
                Verify Your Journey
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900">Sahkan E-mel Anda</h2>
            <p class="text-sm text-gray-600 max-w-md mx-auto">
                Kami telah menghantar pautan pengesahan ke e-mel anda. Klik pautan tersebut untuk mengaktifkan akaun.
                <span class="block mt-1 text-xs text-gray-500">Please check spam if not found the email in inbox.</span>
            </p>
        </div>
        <div class="bg-white shadow-2xl shadow-yellow-100 rounded-3xl border border-yellow-100 p-10 relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-gradient-to-br from-yellow-200 to-yellow-500 opacity-50 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 bottom-0 w-40 h-40 bg-gradient-to-tr from-amber-200 to-yellow-400 opacity-60 blur-3xl pointer-events-none"></div>
            <div class="relative text-center space-y-6">
                <div class="mx-auto w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7m0-7a5 5 0 015 5v2H7v-2a5 5 0 015-5z" />
                    </svg>
                </div>

                @if (session('status'))
                    <div class="rounded-2xl bg-green-50 p-4 text-sm text-green-800 border border-green-100 inline-flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <div class="text-sm text-gray-600">
                    Tidak menerima e-mel? Klik butang di bawah untuk menghantar semula pautan pengesahan.
                </div>

                <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition">
                        Hantar Semula Pautan Pengesahan
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                        Log keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
