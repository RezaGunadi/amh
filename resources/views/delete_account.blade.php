@extends('layouts.public')

@section('title', $title ?? 'Hapus Akun — amhriset')
@section('description', 'Hapus akun amhriset Anda secara permanen. Verifikasi kredensial, tinjau konsekuensinya, lalu konfirmasi penghapusan.')

@section('nav_links')
    <a href="{{ url('/') }}">Beranda</a>
    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
    <a href="{{ url('/terms-conditions') }}">Terms &amp; Conditions</a>
@endsection

@section('nav_actions')
    <a class="btn btn-secondary btn-sm" href="mailto:support@amhriset.com">Butuh bantuan?</a>
@endsection

@section('content')

    @php
        $isVerified = isset($verified) && $verified && isset($user) && $user;
    @endphp

    <section class="page-head">
        <div class="container container-narrow">
            <span class="chip" style="background:var(--danger-soft);border-color:var(--danger-border);color:var(--danger-text)">
                Tindakan permanen
            </span>
            <h1 class="mt-3">Hapus Akun</h1>
            <p>
                {{ $isVerified
                    ? 'Akun Anda telah terverifikasi. Baca peringatan di bawah dengan saksama sebelum melanjutkan.'
                    : 'Masukkan kredensial akun Anda untuk melanjutkan proses penghapusan akun.' }}
            </p>

            {{-- Progress --}}
            <ol class="row mt-5" style="gap:10px 14px;font-size:.88rem;font-weight:700" aria-label="Langkah penghapusan">
                <li class="chip {{ $isVerified ? '' : 'chip-brand' }}">
                    <span>1</span> Verifikasi
                </li>
                <li aria-hidden="true" class="muted">→</li>
                <li class="chip {{ $isVerified ? 'chip-brand' : '' }}">
                    <span>2</span> Konfirmasi
                </li>
                <li aria-hidden="true" class="muted">→</li>
                <li class="chip"><span>3</span> Selesai</li>
            </ol>
        </div>
    </section>

    <section class="section">
        <div class="container container-narrow">

            {{-- ───────────────────────────────────────────────── flash & errors ── --}}
            @if (session('success'))
                <div class="note note-success" style="margin-bottom:24px" role="status">
                    <span class="note-icon" aria-hidden="true">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="note" style="margin-bottom:24px" role="status">
                    <span class="note-icon" aria-hidden="true">ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="note note-danger" style="margin-bottom:24px" role="alert">
                    <span class="note-icon" aria-hidden="true">⚠️</span>
                    <span>
                        <strong>Terjadi kesalahan</strong>
                        <ul style="display:grid;gap:5px;margin-top:6px">
                            @foreach ($errors->all() as $error)
                                <li style="position:relative;padding-left:16px">
                                    <span style="position:absolute;left:0" aria-hidden="true">•</span>{{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </span>
                </div>
            @endif

            @if ($isVerified)
                {{-- ─────────────────────────────────── STEP 2 — confirm deletion ── --}}
                <div class="card">
                    <span class="eyebrow">Akun terverifikasi</span>
                    <h2 style="font-size:1.35rem">Detail akun yang akan dihapus</h2>

                    <div class="spec mt-4">
                        <div class="spec-row">
                            <span class="spec-key">Email</span>
                            <span class="spec-val">{{ $user->email }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Nama</span>
                            <span class="spec-val">{{ $user->name }}</span>
                        </div>
                        @if ($user->hp)
                            <div class="spec-row">
                                <span class="spec-key">No. HP</span>
                                <span class="spec-val">{{ $user->hp }}</span>
                            </div>
                        @endif
                        @if ($user->username)
                            <div class="spec-row">
                                <span class="spec-key">Username</span>
                                <span class="spec-val">{{ $user->username }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="note note-danger mt-5">
                    <span class="note-icon" aria-hidden="true">⚠️</span>
                    <span>
                        <strong>Peringatan penting</strong>
                        <ul style="display:grid;gap:7px;margin-top:8px">
                            <li style="position:relative;padding-left:18px">
                                <span style="position:absolute;left:0" aria-hidden="true">•</span>
                                Penghapusan akun bersifat <strong>permanen dan tidak dapat dibatalkan</strong>
                            </li>
                            <li style="position:relative;padding-left:18px">
                                <span style="position:absolute;left:0" aria-hidden="true">•</span>
                                Semua data akun akan dihapus: email, username, nomor HP
                            </li>
                            <li style="position:relative;padding-left:18px">
                                <span style="position:absolute;left:0" aria-hidden="true">•</span>
                                Riwayat, favorites, dan data terkait akun akan ikut terhapus
                            </li>
                            <li style="position:relative;padding-left:18px">
                                <span style="position:absolute;left:0" aria-hidden="true">•</span>
                                Anda tidak dapat menggunakan email atau username yang sama untuk registrasi ulang
                            </li>
                        </ul>
                    </span>
                </div>

                <div class="card mt-5">
                    <form method="POST" action="{{ route('delete-account.process') }}">
                        @csrf

                        <div class="form-field">
                            <label class="form-label" for="password">Masukkan password untuk konfirmasi akhir</label>
                            <input class="form-control" type="password" id="password" name="password" required
                                placeholder="Password Anda" autocomplete="current-password"
                                @if ($errors->has('password')) aria-invalid="true" @endif>
                        </div>

                        <label class="form-check mt-5" for="confirmation">
                            <input type="checkbox" id="confirmation" name="confirmation" value="1" required>
                            <span>
                                Saya memahami bahwa penghapusan akun bersifat <strong>permanen</strong> dan tidak dapat
                                dibatalkan. Saya setuju untuk menghapus akun saya.
                            </span>
                        </label>

                        <div class="row mt-5">
                            <button type="submit" class="btn btn-danger btn-lg">
                                🗑️ Hapus Akun Saya Secara Permanen
                            </button>
                            <a class="btn btn-ghost" href="{{ route('delete-account.cancel') }}">Batal dan kembali</a>
                        </div>
                    </form>
                </div>
            @else
                {{-- ────────────────────────────────────── STEP 1 — verify login ── --}}
                <div class="card">
                    <span class="eyebrow">Langkah 1</span>
                    <h2 style="font-size:1.35rem">Verifikasi akun Anda</h2>
                    <p class="mt-2">Kami perlu memastikan Anda adalah pemilik akun sebelum menampilkan opsi penghapusan.
                    </p>

                    <form method="POST" action="{{ route('delete-account.verify') }}" class="mt-5">
                        @csrf

                        <div class="form-field">
                            <label class="form-label" for="identifier">Email, username, atau nomor ponsel</label>
                            <input class="form-control" type="text" id="identifier" name="identifier" required
                                placeholder="user@email.com" value="{{ old('identifier') }}" autocomplete="username"
                                @if ($errors->has('identifier')) aria-invalid="true" @endif>
                            <span class="form-hint">
                                Anda dapat menggunakan email, username, atau nomor ponsel untuk login.
                            </span>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" required
                                placeholder="Password Anda" autocomplete="current-password"
                                @if ($errors->has('password')) aria-invalid="true" @endif>
                        </div>

                        <div class="row mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Verifikasi Akun</button>
                            <a class="btn btn-ghost" href="{{ url('/') }}">Kembali ke beranda</a>
                        </div>
                    </form>
                </div>

                <div class="note mt-5">
                    <span class="note-icon" aria-hidden="true">💡</span>
                    <span>
                        <strong>Tidak yakin ingin menghapus?</strong>
                        Jika Anda hanya ingin berhenti menerima notifikasi atau punya kendala teknis, hubungi kami dulu di
                        <a href="mailto:support@amhriset.com">support@amhriset.com</a> — sering kali ada solusi tanpa harus
                        kehilangan data Anda.
                    </span>
                </div>
            @endif

        </div>
    </section>

@endsection
