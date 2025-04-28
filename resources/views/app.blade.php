<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
        
        <!-- Primary Meta Tags -->
        <title inertia>{{ config('app.name', 'IntanDeco') }} - Premium Natural Stone Home Decor from Indonesia</title>
        <meta name="title" content="{{ config('app.name', 'IntanDeco') }} - Premium Natural Stone Home Decor from Indonesia">
        <meta name="description" content="@yield('meta_description', 'Indonesian manufacturer of handcrafted natural stone home decor. Premium sinks, vases, kitchen utensils & furniture made from fossil wood, onyx, and marble since 2000.')">
        <meta name="keywords" content="@yield('meta_keywords', 'natural stone decor, Indonesian crafts, fossil wood decor, onyx home accessories, marble sinks, handcrafted stone products, premium stone vases, stone kitchenware, bathroom accessories, stone wash basins')">
        <meta name="author" content="IntanDeco">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name', 'IntanDeco') }} - Premium Natural Stone Home Decor from Indonesia">
        <meta property="og:description" content="@yield('meta_description', 'Indonesian manufacturer of handcrafted natural stone home decor. Premium sinks, vases, kitchen utensils & furniture made from fossil wood, onyx, and marble since 2000.')">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
        <meta property="og:site_name" content="IntanDeco">
        <meta property="og:locale" content="en_US">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ config('app.name', 'IntanDeco') }} - Premium Natural Stone Home Decor from Indonesia">
        <meta property="twitter:description" content="@yield('meta_description', 'Indonesian manufacturer of handcrafted natural stone home decor. Premium sinks, vases, kitchen utensils & furniture made from fossil wood, onyx, and marble since 2000.')">
        <meta property="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />
        
        <!-- Structured Data / Schema.org -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "IntanDeco",
            "alternateName": "Intan Natural Stone",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "description": "Indonesian manufacturer of handcrafted natural stone home accessories since 2000.",
            "foundingDate": "2000",
            "founder": {
                "@type": "Person",
                "name": "IntanDeco Founder"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "{{ config('company.phone', '+62-000-0000') }}",
                "contactType": "customer service",
                "availableLanguage": ["English", "Indonesian"]
            },
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "Indonesia"
            },
            "sameAs": [
                "{{ config('company.facebook_url', '#') }}",
                "{{ config('company.instagram_url', '#') }}",
                "{{ config('company.linkedin_url', '#') }}"
            ]
        }
        </script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        
        <!-- Preload Critical Assets -->
        <link rel="preload" href="{{ mix('resources/js/app.js') }}" as="script">
        <link rel="preload" href="{{ asset('fonts/main-font.woff2') }}" as="font" type="font/woff2" crossorigin>
        
        <!-- Mobile Web App -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="IntanDeco">
        <meta name="theme-color" content="#ffffff">
        
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        @production
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-MEASUREMENT_ID"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-MEASUREMENT_ID');
        </script>
        @endproduction
        
        <!-- Hreflang tags for language/regional URLs -->
        <link rel="alternate" hreflang="en" href="{{ url('/en') }}" />
        <link rel="alternate" hreflang="id" href="{{ url('/id') }}" />
        <link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-full">
        @inertia
        
        <!-- Flowbite JS -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        
        <!-- Additional Scripts -->
        <script>
            // Dark mode detection
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
            
            // Service Worker Registration
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js').then(registration => {
                        console.log('ServiceWorker registration successful');
                    }).catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>
    </body>
</html>