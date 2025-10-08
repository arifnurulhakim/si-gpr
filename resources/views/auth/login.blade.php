<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SI-GPR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-indigo-800"></div>
            <div class="relative z-10 flex items-center justify-center w-full">
                <div class="text-center text-white px-8">
                    <div class="mb-8">
                        <svg class="mx-auto h-24 w-24 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold mb-4">SI-GPR</h1>
                    <p class="text-xl text-indigo-100 mb-8">Sistem Informasi Griya Pasopati Regency</p>
                    <div class="space-y-4 text-indigo-100">
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Kelola data keluarga dengan mudah</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Pencarian dan filter yang cepat</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Laporan yang terintegrasi</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-20 w-32 h-32 bg-indigo-500 rounded-full opacity-20"></div>
                <div class="absolute bottom-20 right-20 w-24 h-24 bg-indigo-400 rounded-full opacity-30"></div>
                <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-indigo-300 rounded-full opacity-40"></div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Selamat Datang
                    </h2>
                    <p class="text-gray-600">
                        Masuk ke akun Anda untuk melanjutkan
                    </p>
                </div>

                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Login Mode Toggle -->
                    <div class="flex justify-center mb-6">
                        <div class="inline-flex rounded-lg border border-gray-200 bg-gray-100 p-1">
                            <button type="button" id="adminModeBtn" onclick="switchLoginMode('admin')" class="px-4 py-2 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                                Admin Login
                            </button>
                            <button type="button" id="residentModeBtn" onclick="switchLoginMode('resident')" class="px-4 py-2 text-sm font-medium rounded-md text-gray-700">
                                Resident Login
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Admin Login Fields -->
                        <div id="adminLoginFields">
                            <div>
                                <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email / NIK
                                </label>
                                <input id="login" name="login" type="text" autocomplete="username"
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base @error('login') border-red-500 @enderror"
                                       placeholder="admin@ekk.com atau 1234567890123456"
                                       value="{{ old('login') }}">
                                @error('login')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    Masukkan email admin atau NIK Anda
                                </p>
                            </div>
                        </div>

                        <!-- Resident Login Fields -->
                        <div id="residentLoginFields" class="hidden">
                            <div>
                                <label for="block" class="block text-sm font-medium text-gray-700 mb-2">
                                    Blok Rumah
                                </label>
                                <input id="block" name="block" type="text" autocomplete="off"
                                       class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base @error('block') border-red-500 @enderror"
                                       placeholder="Contoh: D1-12">
                                @error('block')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    Masukkan nomor blok rumah Anda (contoh: D1-12)
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <span id="passwordLabel">Password</span>
                            </label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base @error('password') border-red-500 @enderror"
                                   placeholder="Masukkan password Anda">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </span>
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-center">
                    <p class="text-sm text-gray-500">
                        © 2024 SI-GPR. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let loginMode = 'admin'; // Default mode

        function switchLoginMode(mode) {
            loginMode = mode;

            const adminModeBtn = document.getElementById('adminModeBtn');
            const residentModeBtn = document.getElementById('residentModeBtn');
            const adminLoginFields = document.getElementById('adminLoginFields');
            const residentLoginFields = document.getElementById('residentLoginFields');
            const passwordInput = document.getElementById('password');
            const passwordLabel = document.getElementById('passwordLabel');

            if (mode === 'admin') {
                // Show admin fields
                adminLoginFields.classList.remove('hidden');
                residentLoginFields.classList.add('hidden');

                // Update button styles
                adminModeBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                adminModeBtn.classList.remove('text-gray-700');
                residentModeBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                residentModeBtn.classList.add('text-gray-700');

                // Update password field
                passwordLabel.textContent = 'Password';
                passwordInput.placeholder = 'Masukkan password Anda';
                passwordInput.maxLength = '';

                // Set required attributes
                document.getElementById('login').required = true;
                document.getElementById('block').required = false;
            } else {
                // Show resident fields
                adminLoginFields.classList.add('hidden');
                residentLoginFields.classList.remove('hidden');

                // Update button styles
                residentModeBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                residentModeBtn.classList.remove('text-gray-700');
                adminModeBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                adminModeBtn.classList.add('text-gray-700');

                // Update password field for resident (NIK as password)
                passwordLabel.textContent = 'Password (NIK)';
                passwordInput.placeholder = '16 digit NIK';
                passwordInput.maxLength = '16';

                // Set required attributes
                document.getElementById('login').required = false;
                document.getElementById('block').required = true;
            }
        }
    </script>
</body>
</html>
