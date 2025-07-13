<!-- Organization Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "KelasPrivat.id",
    "alternateName": "Kelas Privat",
    "description": "Platform les privat online terbaik di Indonesia dengan pengajar berpengalaman dan metode pembelajaran interaktif.",
    "url": "https://kelasprivat.id",
    "logo": "https://kelasprivat.id/assets/img/logo.png",
    "image": "https://kelasprivat.id/assets/img/hero-image.jpg",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Pendidikan No. 123",
        "addressLocality": "Jakarta",
        "addressRegion": "DKI Jakarta",
        "addressCountry": "ID"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+62-812-1100-6445",
        "contactType": "customer service",
        "availableLanguage": "Indonesian"
    },
    "sameAs": [
        "https://facebook.com/kelasprivat",
        "https://twitter.com/kelasprivat",
        "https://instagram.com/kelasprivat",
        "https://youtube.com/kelasprivat"
    ],
    "foundingDate": "2020",
    "numberOfEmployees": "50-100",
    "serviceArea": {
        "@type": "Country",
        "name": "Indonesia"
    },
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Program Les Privat",
        "itemListElement": [
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "EducationalService",
                    "name": "Les Privat SD",
                    "description": "Program les privat untuk siswa Sekolah Dasar"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "EducationalService",
                    "name": "Les Privat SMP",
                    "description": "Program les privat untuk siswa Sekolah Menengah Pertama"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "EducationalService",
                    "name": "Les Privat SMA",
                    "description": "Program les privat untuk siswa Sekolah Menengah Atas"
                }
            }
        ]
    }
}
</script>

<!-- WebSite Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "KelasPrivat.id",
    "url": "https://kelasprivat.id",
    "description": "Platform les privat online terbaik di Indonesia",
    "publisher": {
        "@type": "Organization",
        "name": "KelasPrivat.id"
    },
    "potentialAction": {
        "@type": "SearchAction",
        "target": "https://kelasprivat.id/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>

<!-- BreadcrumbList Schema -->
@if(isset($breadcrumbs))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrumbs as $index => $breadcrumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "name": "{{ $breadcrumb['name'] }}",
            "item": "{{ $breadcrumb['url'] }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif

<!-- FAQ Schema -->
@if(isset($faqs))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        @foreach($faqs as $faq)
        {
            "@type": "Question",
            "name": "{{ $faq['question'] }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $faq['answer'] }}"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif

<!-- Local Business Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "KelasPrivat.id",
    "description": "Platform les privat online terbaik di Indonesia",
    "url": "https://kelasprivat.id",
    "telephone": "+62-812-1100-6445",
    "email": "info@kelasprivat.id",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Pendidikan No. 123",
        "addressLocality": "Jakarta",
        "addressRegion": "DKI Jakarta",
        "postalCode": "12345",
        "addressCountry": "ID"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.2088,
        "longitude": 106.8456
    },
    "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        ],
        "opens": "08:00",
        "closes": "22:00"
    },
    "priceRange": "$$",
    "currenciesAccepted": "IDR",
    "paymentAccepted": "Cash, Credit Card, Bank Transfer, Digital Wallet"
}
</script> 