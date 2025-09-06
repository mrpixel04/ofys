<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Penuh</label>
        <input type="text"
               id="name"
               name="name"
               value="{{ old('name') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 @error('name') border-red-500 @enderror"
               required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Alamat E-mel</label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 @error('email') border-red-500 @enderror"
               required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Username Field -->
    <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna (Pilihan)</label>
        <input type="text"
               id="username"
               name="username"
               value="{{ old('username') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 @error('username') border-red-500 @enderror">
        @error('username')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Laluan</label>
        <input type="password"
               id="password"
               name="password"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 @error('password') border-red-500 @enderror"
               required>
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password Field -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Sahkan Kata Laluan</label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
               required>
    </div>

    <!-- Terms and Privacy -->
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input type="checkbox"
                   id="terms"
                   name="terms"
                   value="1"
                   class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300 rounded @error('terms') border-red-500 @enderror"
                   required>
        </div>
        <div class="ml-3 text-sm">
            <label for="terms" class="text-gray-700">
                Saya bersetuju dengan
                <a href="{{ route('legal.terms') }}" target="_blank" class="text-yellow-600 hover:text-yellow-500 font-medium">Terma Perkhidmatan</a>
                dan
                <a href="{{ route('legal.privacy') }}" target="_blank" class="text-yellow-600 hover:text-yellow-500 font-medium">Dasar Privasi</a>
            </label>
            @error('terms')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
            Daftar Akaun
        </button>
    </div>
</form>
