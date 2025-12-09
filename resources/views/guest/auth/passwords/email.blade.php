@extends('layouts.simple-app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">{{ __('Lupa Kata Laluan?') }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan alamat e-mel anda dan kami akan menghantar pautan untuk menetapkan semula kata laluan.
            </p>
        </div>
        <div class="bg-white shadow-2xl shadow-yellow-100 rounded-3xl p-8 space-y-6 border border-gray-100">
            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 border border-green-100 text-green-800 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat E-mel</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                        Hantar Pautan Tetapan Semula
                    </button>
                </div>
            </form>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-yellow-500 hover:text-yellow-600">
                    Kembali ke halaman log masuk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
