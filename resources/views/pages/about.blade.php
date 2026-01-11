@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Tentang Kami</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
                Memberikan Kualitas Terbaik.
            </p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500 dark:text-gray-400">
                TaleSpindle Studio didirikan pada tahun 2024 dengan misi menyediakan produk berkualitas tinggi dengan harga yang terjangkau bagi semua orang.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="pt-6">
                <div class="flow-root bg-gray-50 dark:bg-gray-700 rounded-lg px-6 pb-8">
                    <div class="-mt-6">
                        <div class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-white tracking-tight">Pengiriman Cepat</h3>
                        <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                            Kami bekerja sama dengan logistik terbaik untuk memastikan barang sampai di tangan Anda tepat waktu.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="flow-root bg-gray-50 dark:bg-gray-700 rounded-lg px-6 pb-8">
                    <div class="-mt-6">
                        <div class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-white tracking-tight">Jaminan Kualitas</h3>
                        <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                            Setiap produk melalui proses quality control yang ketat sebelum dikirimkan kepada Anda.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="flow-root bg-gray-50 dark:bg-gray-700 rounded-lg px-6 pb-8">
                    <div class="-mt-6">
                        <div class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-white tracking-tight">Layanan 24/7</h3>
                        <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                            Tim support kami siap membantu pertanyaan dan kendala Anda kapanpun Anda butuhkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
