<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="en">

<head>
    <base href="../../">
    <title>
        Mubashar Admin
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    {{-- <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" rel="canonical" /> --}}
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    {{-- <meta content="" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" /> --}}
    {{-- <meta content="Metronic - Tailwind CSS " name="twitter:title" /> --}}
    {{-- <meta content="" name="twitter:description" /> --}}
    {{-- <meta content="assets/media/app/og-image.png" name="twitter:image" /> --}}
    {{-- <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" /> --}}
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    {{-- <meta content="@keenthemes" property="og:site_name" /> --}}
    {{-- <meta content="Metronic - Tailwind CSS " property="og:title" /> --}}
    {{-- <meta content="" property="og:description" /> --}}
    <meta content="{{ asset('assets/images/logo2.png') }}" property="og:image" />
    <link href="{{ asset('assets/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
    <link href="{{ asset('assets/images/logo2.png') }}" rel="icon" sizes="32x32" type="image/png" />
    <link href="{{ asset('assets/images/logo2.png') }}" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('assets/images/logo2.png') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
</head>

<body
    class="mt-20">
    <!-- Theme Mode -->
    {{-- <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('theme')) {
                themeMode = localStorage.getItem('theme');
            } else if (document.documentElement.hasAttribute('data-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script> --}}
    <!-- End of Theme Mode -->
    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
    
        <!-- Wrapper -->
        <div class="wrapper flex grow flex-col">
          
            <!-- Content -->
            @yield('content')
            <!-- End of Content -->
         
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->

    <!-- End of Page -->
    <!-- Scripts -->
    <script src="{{ asset('assets/js/core.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/widgets/general.js') }}"></script>
    <script src="{{ asset('assets/js/layouts/main.js') }}"></script>

    <!-- End of Scripts -->
</body>

</html>
