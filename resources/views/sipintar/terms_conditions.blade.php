@extends('layouts.public')

@section('title', $title ?? 'Terms & Conditions — Sipintar')
@section('description', 'Terms and Conditions for the Sipintar mobile application: acceptable use, accounts, content ownership, disclaimers, and termination.')

@section('nav_links')
    <a href="{{ url('/sipintar') }}">Sipintar</a>
    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
    <a href="{{ url('/delete-account') }}">Hapus Akun</a>
@endsection

@section('content')

    <section class="page-head">
        <div class="container">
            <span class="chip chip-sipintar">Sipintar</span>
            <h1 class="mt-3">Terms &amp; Conditions</h1>
            <p>
                Dengan mengunduh, memasang, atau menggunakan aplikasi Sipintar, Anda terikat pada syarat dan ketentuan
                berikut.
            </p>
            <div class="row mt-4">
                <span class="chip">Terakhir diperbarui: 13 Oktober 2025</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="doc-layout">

                <aside class="toc" aria-label="Daftar isi">
                    <div class="toc-title">Daftar isi</div>
                    <ul>
                        <li><a href="#acceptance">1. Acceptance of Terms</a></li>
                        <li><a href="#service">2. Description of Service</a></li>
                        <li><a href="#accounts">3. User Accounts</a></li>
                        <li><a href="#acceptable-use">4. Acceptable Use</a></li>
                        <li><a href="#content">5. Content &amp; IP</a></li>
                        <li><a href="#privacy">6. Privacy &amp; Data</a></li>
                        <li><a href="#disclaimers">7. Disclaimers</a></li>
                        <li><a href="#termination">8. Account Termination</a></li>
                        <li><a href="#modifications">9. Modifications</a></li>
                        <li><a href="#law">10. Governing Law</a></li>
                        <li><a href="#contact">11. Contact Information</a></li>
                        <li><a href="#severability">12. Severability</a></li>
                        <li><a href="#agreement">13. Entire Agreement</a></li>
                    </ul>
                </aside>

                <div class="prose">
                    <div class="note note-warning">
                        <span class="note-icon" aria-hidden="true">⚠️</span>
                        <span>
                            <strong>Important</strong>
                            By downloading, installing, or using the Sipintar mobile application, you agree to be bound by
                            these Terms and Conditions. If you do not agree to these Terms, please do not use our app.
                        </span>
                    </div>

                    <h2 id="acceptance">1. Acceptance of Terms</h2>
                    <p>By downloading, installing, or using the Sipintar mobile application, you agree to be bound by
                        these Terms and Conditions ("Terms"). If you do not agree to these Terms, please do not use our
                        app.</p>

                    <h2 id="service">2. Description of Service</h2>
                    <p>Sipintar is a mobile application that provides:</p>
                    <ul>
                        <li>Food menu information and nutritional data</li>
                        <li>Food consumption tracking</li>
                        <li>Personalized recommendations</li>
                        <li>Educational content about nutrition</li>
                    </ul>

                    <h2 id="accounts">3. User Accounts</h2>

                    <h3>3.1 Account Creation</h3>
                    <ul>
                        <li>You may create an account or use the app as a guest</li>
                        <li>You must provide accurate and complete information</li>
                        <li>You are responsible for maintaining account security</li>
                    </ul>

                    <h3>3.2 Account Responsibilities</h3>
                    <ul>
                        <li>Keep your login credentials secure</li>
                        <li>Notify us immediately of any unauthorized access</li>
                        <li>You are responsible for all activities under your account</li>
                    </ul>

                    <h2 id="acceptable-use">4. Acceptable Use</h2>

                    <h3>4.1 Permitted Uses</h3>
                    <ul>
                        <li>Personal, non-commercial use</li>
                        <li>Educational purposes</li>
                        <li>Sharing content with proper attribution</li>
                    </ul>

                    <h3>4.2 Prohibited Uses</h3>
                    <p>You may not:</p>
                    <ul>
                        <li>Use the app for illegal activities</li>
                        <li>Attempt to hack or compromise the app</li>
                        <li>Share inappropriate or offensive content</li>
                        <li>Violate intellectual property rights</li>
                        <li>Spam or harass other users</li>
                    </ul>

                    <h2 id="content">5. Content and Intellectual Property</h2>

                    <h3>5.1 Our Content</h3>
                    <ul>
                        <li>All app content, features, and functionality are owned by Sipintar</li>
                        <li>Content is protected by copyright and trademark laws</li>
                        <li>You may not copy, modify, or distribute our content without permission</li>
                    </ul>

                    <h3>5.2 User Content</h3>
                    <ul>
                        <li>You retain ownership of content you create</li>
                        <li>You grant us a license to use your content to provide services</li>
                        <li>You are responsible for ensuring you have rights to any content you share</li>
                    </ul>

                    <h2 id="privacy">6. Privacy and Data Protection</h2>
                    <ul>
                        <li>Your privacy is important to us</li>
                        <li>Please review our <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> for details on
                            data collection and use</li>
                        <li>We comply with applicable privacy laws and regulations</li>
                    </ul>

                    <h3>6.1 Use of Camera and Microphone</h3>
                    <div class="note">
                        <span class="note-icon" aria-hidden="true">📷</span>
                        <span>
                            <strong>Camera and Microphone Access</strong>
                            <ul style="display:grid;gap:8px;margin-top:8px">
                                <li style="position:relative;padding-left:18px">
                                    <span style="position:absolute;left:0">•</span>
                                    Aplikasi Si Pintar menggunakan kamera dan mikrofon hanya untuk keperluan fitur
                                    pengawasan, bukan untuk merekam atau membagikan data pengguna ke pihak lain.
                                </li>
                                <li style="position:relative;padding-left:18px">
                                    <span style="position:absolute;left:0">•</span>
                                    Kami tidak menyimpan data foto atau video di server tanpa izin pengguna. Semua akses
                                    kamera dan mikrofon dilakukan secara lokal pada perangkat pengguna.
                                </li>
                                <li style="position:relative;padding-left:18px">
                                    <span style="position:absolute;left:0">•</span>
                                    Data pribadi (seperti email, foto, lokasi) hanya digunakan untuk mendukung fungsi
                                    aplikasi dan tidak dibagikan ke pihak ketiga.
                                </li>
                                <li style="position:relative;padding-left:18px">
                                    <span style="position:absolute;left:0">•</span>
                                    Pengguna memiliki kontrol penuh untuk memberikan atau mencabut izin akses kamera dan
                                    mikrofon melalui pengaturan perangkat.
                                </li>
                            </ul>
                        </span>
                    </div>

                    <h2 id="disclaimers">7. Disclaimers and Limitations</h2>

                    <h3>7.1 Service Availability</h3>
                    <ul>
                        <li>We strive for 24/7 availability but cannot guarantee uninterrupted service</li>
                        <li>We may modify or discontinue features at any time</li>
                        <li>We are not responsible for third-party service interruptions</li>
                    </ul>

                    <h3>7.2 Health and Nutrition Information</h3>
                    <div class="note note-warning">
                        <span class="note-icon" aria-hidden="true">🩺</span>
                        <span>
                            <strong>Bukan nasihat medis</strong>
                            Informasi yang disediakan bersifat edukatif saja dan bukan merupakan nasihat medis maupun
                            diet. Konsultasikan keputusan kesehatan dengan tenaga profesional. Kami tidak bertanggung
                            jawab atas hasil kesehatan yang timbul dari penggunaan informasi ini.
                        </span>
                    </div>

                    <h3>7.3 Limitation of Liability</h3>
                    <ul>
                        <li>We provide the app "as is" without warranties</li>
                        <li>We are not liable for indirect, incidental, or consequential damages</li>
                        <li>Our liability is limited to the amount you paid for the app (if any)</li>
                    </ul>

                    <h2 id="termination">8. Account Termination</h2>

                    <h3>8.1 Your Right to Terminate</h3>
                    <ul>
                        <li>You may <a href="{{ url('/delete-account') }}">delete your account</a> at any time</li>
                        <li>Account deletion is permanent and irreversible</li>
                        <li>You can request data deletion as per our Privacy Policy</li>
                    </ul>

                    <h3>8.2 Our Right to Terminate</h3>
                    <p>We may suspend or terminate your account if you:</p>
                    <ul>
                        <li>Violate these Terms</li>
                        <li>Engage in fraudulent or illegal activities</li>
                        <li>Abuse the service or other users</li>
                    </ul>

                    <h2 id="modifications">9. Modifications</h2>
                    <ul>
                        <li>We may update these Terms at any time</li>
                        <li>Continued use after changes constitutes acceptance</li>
                        <li>We will notify users of significant changes</li>
                    </ul>

                    <h2 id="law">10. Governing Law</h2>
                    <p>These Terms are governed by the laws of [Your Jurisdiction]. Any disputes will be resolved in the
                        courts of [Your Jurisdiction].</p>

                    <h2 id="contact">11. Contact Information</h2>
                    <p>For questions about these Terms:</p>
                    <div class="spec">
                        <div class="spec-row">
                            <span class="spec-key">Email</span>
                            <span class="spec-val"><a href="mailto:legal@sipintar.com">legal@sipintar.com</a></span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Alamat</span>
                            <span class="spec-val">[Your Company Address]</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Telepon</span>
                            <span class="spec-val">[Your Contact Number]</span>
                        </div>
                    </div>

                    <h2 id="severability">12. Severability</h2>
                    <p>If any provision of these Terms is found to be unenforceable, the remaining provisions will remain
                        in effect.</p>

                    <h2 id="agreement">13. Entire Agreement</h2>
                    <p>These Terms, together with our Privacy Policy, constitute the entire agreement between you and
                        Sipintar regarding the use of our app.</p>

                    <div class="note note-warning mt-6">
                        <span class="note-icon" aria-hidden="true">✅</span>
                        <span>
                            By using Sipintar, you acknowledge that you have read, understood, and agree to be bound by
                            these Terms and Conditions.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
