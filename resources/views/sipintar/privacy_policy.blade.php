@extends('layouts.public')

@section('title', $title ?? 'Privacy Policy — Sipintar')
@section('description', 'Privacy Policy for the Sipintar mobile application: what we collect, how we use it, how we protect it, and the rights you have over your data.')

@section('nav_links')
    <a href="{{ url('/sipintar') }}">Sipintar</a>
    <a href="{{ url('/terms-conditions') }}">Terms &amp; Conditions</a>
    <a href="{{ url('/delete-account') }}">Hapus Akun</a>
@endsection

@section('content')

    <section class="page-head">
        <div class="container">
            <span class="chip chip-sipintar">Sipintar</span>
            <h1 class="mt-3">Privacy Policy</h1>
            <p>
                Kebijakan ini menjelaskan bagaimana Sipintar mengumpulkan, menggunakan, dan melindungi informasi Anda.
                Dengan menggunakan aplikasi, Anda menyetujui kebijakan ini.
            </p>
            <div class="row mt-4">
                <span class="chip">Terakhir diperbarui: 13 Oktober 2025</span>
                <span class="chip chip-brand">GDPR &amp; CCPA compliant</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="doc-layout">

                <aside class="toc" aria-label="Daftar isi">
                    <div class="toc-title">Daftar isi</div>
                    <ul>
                        <li><a href="#introduction">1. Introduction</a></li>
                        <li><a href="#information-we-collect">2. Information We Collect</a></li>
                        <li><a href="#how-we-use">3. How We Use Your Information</a></li>
                        <li><a href="#sharing">4. Information Sharing</a></li>
                        <li><a href="#security">5. Data Security</a></li>
                        <li><a href="#your-rights">6. Your Rights</a></li>
                        <li><a href="#retention">7. Data Retention</a></li>
                        <li><a href="#children">8. Children's Privacy</a></li>
                        <li><a href="#transfers">9. International Transfers</a></li>
                        <li><a href="#changes">10. Changes to This Policy</a></li>
                        <li><a href="#contact">11. Contact Us</a></li>
                        <li><a href="#compliance">12. Compliance</a></li>
                    </ul>
                </aside>

                <div class="prose">
                    <div class="note note-success">
                        <span class="note-icon" aria-hidden="true">🛡️</span>
                        <span>
                            <strong>Important</strong>
                            This Privacy Policy explains how Sipintar collects, uses, and protects your information. By
                            using our app, you agree to this policy.
                        </span>
                    </div>

                    <h2 id="introduction">1. Introduction</h2>
                    <p>Sipintar ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy
                        explains how we collect, use, disclose, and safeguard your information when you use our mobile
                        application.</p>

                    <h2 id="information-we-collect">2. Information We Collect</h2>

                    <h3>2.1 Information You Provide</h3>
                    <ul>
                        <li><strong>Account Information:</strong> Name, email address, username, school information</li>
                        <li><strong>Profile Data:</strong> Profile picture, personal preferences</li>
                        <li><strong>Content:</strong> Food favorites, consumption history, ratings</li>
                    </ul>

                    <h3>2.2 Information We Collect Automatically</h3>
                    <ul>
                        <li><strong>Usage Data:</strong> App interactions, features used, time spent</li>
                        <li><strong>Device Information:</strong> Device type, operating system, app version</li>
                        <li><strong>Location Data:</strong> General location (if permitted) for regional content</li>
                    </ul>

                    <h3>2.3 Information from Third Parties</h3>
                    <ul>
                        <li><strong>Authentication:</strong> Google Sign-In data (if used)</li>
                        <li><strong>Analytics:</strong> App performance and usage statistics</li>
                    </ul>

                    <h2 id="how-we-use">3. How We Use Your Information</h2>
                    <p>We use your information to:</p>
                    <ul>
                        <li>Provide and maintain the app services</li>
                        <li>Personalize your experience</li>
                        <li>Track food consumption and preferences</li>
                        <li>Improve app functionality</li>
                        <li>Send important updates and notifications</li>
                        <li>Ensure app security and prevent fraud</li>
                    </ul>

                    <h2 id="sharing">4. Information Sharing</h2>
                    <p>We do not sell your personal information. We may share information:</p>
                    <ul>
                        <li>With your explicit consent</li>
                        <li>To comply with legal obligations</li>
                        <li>To protect our rights and safety</li>
                        <li>With service providers (under strict confidentiality)</li>
                    </ul>

                    <h2 id="security">5. Data Security</h2>
                    <p>We implement appropriate security measures:</p>
                    <ul>
                        <li>Encryption of sensitive data</li>
                        <li>Secure data transmission</li>
                        <li>Regular security audits</li>
                        <li>Access controls and authentication</li>
                    </ul>

                    <h2 id="your-rights">6. Your Rights</h2>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access your personal data</li>
                        <li>Correct inaccurate information</li>
                        <li>Delete your account and data</li>
                        <li>Withdraw consent</li>
                        <li>Data portability</li>
                        <li>Object to processing</li>
                    </ul>
                    <p>Anda dapat menggunakan hak penghapusan akun kapan saja melalui
                        <a href="{{ url('/delete-account') }}">halaman hapus akun</a>.
                    </p>

                    <h2 id="retention">7. Data Retention</h2>
                    <p>We retain your information:</p>
                    <ul>
                        <li>While your account is active</li>
                        <li>As required by law</li>
                        <li>For legitimate business purposes</li>
                        <li>You can request deletion at any time</li>
                    </ul>

                    <h2 id="children">8. Children's Privacy</h2>
                    <p>Our app is suitable for all ages. We do not knowingly collect personal information from children
                        under 13 without parental consent.</p>

                    <h2 id="transfers">9. International Transfers</h2>
                    <p>Your data may be transferred to and processed in countries other than your own. We ensure
                        appropriate safeguards are in place.</p>

                    <h2 id="changes">10. Changes to This Policy</h2>
                    <p>We may update this Privacy Policy. We will notify you of significant changes through the app or
                        email.</p>

                    <h2 id="contact">11. Contact Us</h2>
                    <p>For questions about this Privacy Policy:</p>
                    <div class="spec">
                        <div class="spec-row">
                            <span class="spec-key">Email</span>
                            <span class="spec-val"><a href="mailto:privacy@sipintar.com">privacy@sipintar.com</a></span>
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

                    <h2 id="compliance">12. Compliance</h2>
                    <p>This Privacy Policy complies with:</p>
                    <ul>
                        <li>GDPR (General Data Protection Regulation)</li>
                        <li>CCPA (California Consumer Privacy Act)</li>
                        <li>Google Play Store requirements</li>
                        <li>Apple App Store requirements</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
