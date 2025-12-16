@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Masuk ke Akun
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Atau
            <a href="{{ route('register') }}" class="font-medium text-black hover:text-gray-700 underline">
                daftar akun baru
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl shadow-gray-200 sm:rounded-xl sm:px-10 border border-gray-100">
            <form class="space-y-6" action="{{ route('login.authenticate') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm transition">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm transition">
                    </div>
                </div>

                {{-- Button --}}
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gray-900 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition transform hover:-translate-y-0.5">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
