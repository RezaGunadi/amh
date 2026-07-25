@extends('layouts.public')

@section('title', $title ?? 'Kebijakan Privasi — Kelas Privat')
@section('description', 'Kebijakan Privasi aplikasi Kelas Privat: data yang kami kumpulkan, alasan pemrosesan, hak-hak Anda, dan cara menghubungi kami.')

@section('nav_links')
    <a href="{{ url('/tnc-child-care') }}">Kebijakan Child Care</a>
    <a href="{{ url('/delete-account') }}">Hapus Akun</a>
@endsection

@section('content')

    <section class="page-head">
        <div class="container">
            <span class="chip chip-brand">Kelas Privat</span>
            <h1 class="mt-3">Kebijakan Privasi</h1>
            <p>
                Bagaimana Kelas Privat mengumpulkan, memproses, dan melindungi data Anda — beserta hak yang Anda miliki
                atas data tersebut.
            </p>
            <div class="row mt-4">
                <span class="chip">Pengontrol data: kelas-privat.com</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="doc-layout">

                <aside class="toc" aria-label="Daftar isi">
                    <div class="toc-title">Daftar isi</div>
                    <ul>
                        <li><a href="#informasi-yang-dikumpulkan">Informasi yang dikumpulkan</a></li>
                        <li><a href="#mengapa-diproses">Mengapa data diproses</a></li>
                        <li><a href="#hak-anda">Hak-hak Anda</a></li>
                        <li><a href="#link-aplikasi-lain">Link ke aplikasi lain</a></li>
                        <li><a href="#keamanan-informasi">Keamanan informasi</a></li>
                        <li><a href="#pengungkapan-hukum">Pengungkapan hukum</a></li>
                        <li><a href="#kontak">Informasi kontak</a></li>
                    </ul>
                </aside>

                @include('tnc.partials.privacy-content', [
                    'appName' => 'Kelas Privat',
                    'deviceLabel' => 'Kelas Privat',
                ])
            </div>
        </div>
    </section>

@endsection
