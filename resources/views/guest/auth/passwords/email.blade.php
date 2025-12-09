@extends('layouts.simple-app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full">
        <div class="text-center mb-8">
            <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 tracking-widest uppercase">
                OFYS Account Recovery
            </span>
            <h2 class="mt-4 text-3xl font-extrabold text-gray-900">{{ __('Lupa Kata Laluan?') }}</h2>
            <p class="mt-2 text-sm text-gray-600 max-w-md mx-auto">
                Masukkan alamat e-mel anda dan kami akan menghantar pautan untuk menetapkan semula kata laluan.
                <span class="block mt-1 text-xs text-gray-500 font-medium">Please check spam if not found the email in inbox.</span>
            </p>
        </div>
        <div class="bg-white shadow-2xl shadow-yellow-100 rounded-3xl border border-yellow-100 p-8 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-gradient-to-br from-yellow-200 to-yellow-400 opacity-60 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -left-6 -bottom-8 w-28 h-28 bg-gradient-to-tr from-yellow-200 to-yellow-500 opacity-60 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative space-y-6">
                @if (session('status'))
                    <div class="rounded-2xl bg-green-50 p-4 border border-green-100 text-green-800 text-sm flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6 relative z-10">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat E-mel</label>
                        <div class="mt-2 relative rounded-2xl shadow-sm">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="appearance-none block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition"
                                placeholder="nama@emel.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center py-3 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition">
                            Hantar Pautan Tetapan Semula
                        </button>
                    </div>
                </form>
                <div class="text-center text-sm relative z-10">
                    <a href="{{ route('login') }}" class="font-semibold text-yellow-600 hover:text-yellow-500">
                        Kembali ke halaman log masuk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
