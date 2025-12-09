@extends('layouts.simple-app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">{{ __('Tetapkan Semula Kata Laluan') }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                Buat kata laluan baharu untuk akaun anda.
            </p>
        </div>
        <div class="bg-white shadow-2xl shadow-yellow-100 rounded-3xl p-8 space-y-6 border border-gray-100">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat E-mel</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required autofocus
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Laluan Baharu</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Sahkan Kata Laluan</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                        Simpan Kata Laluan Baharu
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
