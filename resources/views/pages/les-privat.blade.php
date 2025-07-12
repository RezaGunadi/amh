@extends('layouts.app')

@section('title', 'Les Privat Online Terbaik di Indonesia | KelasPrivat.id')
@section('meta_description', 'Temukan les privat online terbaik dengan guru berpengalaman. Program les privat SD, SMP, SMA dengan metode pembelajaran interaktif dan bank soal gratis.')
@section('meta_keywords', 'les privat, les privat online, les privat SD, les privat SMP, les privat SMA, guru les privat, bimbel online, bank soal gratis')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Les Privat Online Terbaik di Indonesia
                </h1>
                <p class="mt-6 text-xl text-indigo-100 max-w-3xl mx-auto">
                    Tingkatkan prestasi akademik dengan program les privat online yang dipandu oleh guru-guru berpengalaman. Metode pembelajaran interaktif dan bank soal gratis untuk SD, SMP, dan SMA.
                </p>
                <div class="mt-10">
                    <a href="/register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                        Mulai Les Privat Online
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Mengapa Memilih Les Privat Online Kami?
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Kami menawarkan solusi pembelajaran terbaik untuk meningkatkan prestasi akademik siswa
                </p>
            </div>

            <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Guru Berpengalaman</h3>
                    <p class="text-gray-600">
                        Tim pengajar kami terdiri dari guru-guru profesional dengan pengalaman mengajar minimal 5 tahun dan lulusan universitas terbaik.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pembelajaran Interaktif</h3>
                    <p class="text-gray-600">
                        Metode pembelajaran yang menyenangkan dan interaktif menggunakan teknologi modern untuk memaksimalkan pemahaman siswa.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Bank Soal Gratis</h3>
                    <p class="text-gray-600">
                        Akses ribuan soal latihan gratis untuk semua mata pelajaran, membantu siswa berlatih dan meningkatkan kemampuan akademik.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Program Les Privat Online
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Program les privat online yang dirancang khusus untuk setiap jenjang pendidikan
                </p>
            </div>

            <div class="mt-12 space-y-12">
                <!-- SD Program -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Les Privat SD</h3>
                        <ul class="space-y-4 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Mata pelajaran: Matematika, IPA, Bahasa Indonesia, Bahasa Inggris</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Metode pembelajaran yang menyenangkan dan mudah dipahami</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Latihan soal sesuai kurikulum terbaru</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SMP Program -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Les Privat SMP</h3>
                        <ul class="space-y-4 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Mata pelajaran: Matematika, IPA, Bahasa Indonesia, Bahasa Inggris, IPS</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Persiapan Ujian Nasional dan Ujian Sekolah</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Bank soal lengkap dengan pembahasan</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SMA Program -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Les Privat SMA</h3>
                        <ul class="space-y-4 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Program IPA: Matematika, Fisika, Kimia, Biologi</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Program IPS: Ekonomi, Geografi, Sejarah, Sosiologi</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Persiapan UTBK dan Ujian Mandiri</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Siap untuk meningkatkan prestasi akademik?</span>
                <span class="block text-indigo-200">Daftar sekarang dan dapatkan konsultasi gratis!</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="/register" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Daftar Sekarang
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="/contact" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 