{{--
    Shared privacy-policy body for the amhriset apps.

    Required:  $appName      e.g. "Child Care"
    Optional:  $deviceLabel  how the registered hardware is referred to in prose
--}}
@php
    $deviceLabel = $deviceLabel ?? strtolower($appName);
@endphp

<div class="prose">
    <p>
        Aplikasi <strong>{{ $appName }}</strong> dimiliki oleh kelas-privat.com, yang akan menjadi pengontrol atas
        data pribadi Anda.
    </p>
    <p>
        Kami telah mengadopsi Kebijakan Privasi ini untuk menjelaskan bagaimana kami memproses informasi yang
        dikumpulkan oleh {{ $appName }}, yang juga menjelaskan alasan mengapa kami perlu mengumpulkan data pribadi
        tertentu tentang Anda. Oleh karena itu, Anda harus membaca Kebijakan Privasi ini sebelum menggunakan aplikasi
        {{ $appName }}.
    </p>

    <div class="note note-success">
        <span class="note-icon" aria-hidden="true">🔒</span>
        <span>Kami menjaga data pribadi Anda dan berjanji untuk menjamin kerahasiaan dan keamanannya.</span>
    </div>

    <h2 id="informasi-yang-dikumpulkan">Informasi pribadi yang kami kumpulkan</h2>
    <p>
        Saat Anda mendaftarkan perangkat {{ $deviceLabel }} yang Anda miliki pada aplikasi {{ $appName }}, kami secara
        otomatis mengumpulkan informasi tertentu mengenai data suhu tubuh, kadar keringat, detak jantung, dan lokasi
        anak Anda — juga selama Anda menggunakan aplikasi. Kami menyebut informasi yang dikumpulkan secara otomatis ini
        sebagai <strong>"Informasi Perangkat"</strong>.
    </p>
    <p>
        Kemudian, kami mungkin akan mengumpulkan data pribadi yang Anda berikan kepada kami (termasuk tetapi tidak
        terbatas pada informasi nama, email, nomor ponsel, dan sejenisnya) selama pendaftaran untuk dapat memenuhi
        perjanjian.
    </p>

    <h2 id="mengapa-diproses">Mengapa kami memproses data Anda?</h2>
    <p>
        Menjaga data pelanggan agar tetap aman adalah prioritas utama kami. Oleh karena itu, kami hanya memproses
        sejumlah kecil data pengguna — sebanyak yang benar-benar diperlukan untuk menjalankan aplikasi. Informasi yang
        dikumpulkan secara otomatis hanya digunakan untuk mengidentifikasi kemungkinan kasus penyalahgunaan dan
        menyusun informasi statistik terkait penggunaan aplikasi. Informasi statistik ini tidak digabungkan sedemikian
        rupa hingga dapat mengidentifikasi pengguna tertentu dari sistem.
    </p>
    <p>
        Anda dapat mengunjungi aplikasi tanpa memberi tahu identitas Anda atau mengungkapkan informasi apa pun yang
        dapat digunakan untuk mengidentifikasi Anda sebagai individu tertentu. Namun, jika Anda ingin menggunakan
        beberapa fitur aplikasi atau menerima dan memberikan detail lainnya, Anda diharuskan mengisi formulir dan dapat
        memberikan data pribadi kepada kami, seperti email, nama lengkap, dan nomor telepon Anda.
    </p>
    <p>
        Anda dapat memilih untuk tidak memberikan data pribadi kepada kami, tetapi Anda mungkin tidak dapat
        memanfaatkan seluruh fitur aplikasi — contohnya, Anda tidak akan dapat menghubungkan dan menerima data dari
        perangkat pada aplikasi. Pengguna yang tidak yakin tentang informasi yang wajib diberikan dapat menghubungi kami
        melalui <a href="mailto:rezagunadi97@gmail.com">rezagunadi97@gmail.com</a>.
    </p>

    <h2 id="hak-anda">Hak-hak Anda</h2>
    <p>Jika Anda seorang warga Indonesia, Anda memiliki hak-hak berikut terkait data pribadi Anda:</p>
    <ul>
        <li>Hak untuk mendapatkan penjelasan</li>
        <li>Hak atas akses</li>
        <li>Hak untuk memperbaiki</li>
        <li>Hak untuk menghapus</li>
        <li>Hak untuk membatasi pemrosesan</li>
        <li>Hak atas portabilitas data</li>
        <li>Hak untuk menolak</li>
        <li>Hak-hak terkait pengambilan keputusan dan pembuatan profil otomatis</li>
    </ul>
    <p>
        Jika Anda ingin menggunakan hak ini, silakan hubungi kami melalui informasi kontak di bawah. Untuk penghapusan
        akun, Anda juga dapat menggunakan <a href="{{ url('/delete-account') }}">halaman hapus akun</a>.
    </p>

    <h2 id="link-aplikasi-lain">Link ke aplikasi lain</h2>
    <p>
        Aplikasi kami mungkin berisi tautan ke aplikasi lain yang tidak dimiliki atau dikendalikan oleh kami. Perlu
        diketahui bahwa kami tidak bertanggung jawab atas praktik privasi aplikasi lain atau pihak ketiga. Kami
        menyarankan Anda untuk selalu waspada ketika meninggalkan aplikasi kami dan membaca pernyataan privasi setiap
        aplikasi yang mungkin mengumpulkan informasi pribadi.
    </p>

    <h2 id="keamanan-informasi">Keamanan informasi</h2>
    <p>
        Kami menjaga keamanan informasi yang Anda berikan pada server komputer dalam lingkungan yang terkendali, aman,
        dan terlindungi dari akses, penggunaan, atau pengungkapan yang tidak sah. Kami menjaga pengamanan
        administratif, teknis, dan fisik yang wajar untuk perlindungan terhadap akses, penggunaan, modifikasi, dan
        pengungkapan tidak sah atas data pribadi dalam kendali dan pengawasan kami. Namun, kami tidak dapat menjamin
        keamanan mutlak atas transmisi data melalui Internet atau jaringan nirkabel.
    </p>

    <h2 id="pengungkapan-hukum">Pengungkapan hukum</h2>
    <p>
        Kami akan mengungkapkan informasi apa pun yang kami kumpulkan, gunakan, atau terima jika diwajibkan atau
        diizinkan oleh hukum — misalnya untuk mematuhi panggilan pengadilan atau proses hukum serupa, dan jika kami
        percaya dengan itikad baik bahwa pengungkapan diperlukan untuk melindungi hak kami, melindungi keselamatan Anda
        atau keselamatan orang lain, menyelidiki penipuan, atau menanggapi permintaan dari pemerintah.
    </p>

    <h2 id="kontak">Informasi kontak</h2>
    <p>
        Jika Anda ingin menghubungi kami untuk mempelajari Kebijakan ini lebih lanjut atau menanyakan masalah apa pun
        yang berkaitan dengan hak perorangan dan informasi pribadi Anda, Anda dapat mengirim email ke alamat berikut.
    </p>
    <div class="spec">
        <div class="spec-row">
            <span class="spec-key">Email</span>
            <span class="spec-val"><a href="mailto:rezagunadi97@gmail.com">rezagunadi97@gmail.com</a></span>
        </div>
        <div class="spec-row">
            <span class="spec-key">Pengontrol data</span>
            <span class="spec-val">kelas-privat.com</span>
        </div>
    </div>
</div>
