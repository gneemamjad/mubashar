<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    @if(app()->getLocale() == 'ar')
        <link href="{{ asset('assets/css/rtl.css') }}" rel="stylesheet" type="text/css"/>
    @endif
    @yield('custom-styles')
</head>

<body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#fefefe] [--tw-page-bg-dark:var(--tw-coal-500)] demo1 sidebar-fixed header-fixed bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]">
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
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->
        <!-- Wrapper -->
        <div class="wrapper flex grow flex-col">
            <!-- Header -->
            @include('layouts.header')
            <!-- End of Header -->

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-5 mt-5 bg-success-light border border-success-200 rounded-xl shadow-lg animate-slideInDown" role="alert">
                <div class="flex items-center gap-4 p-4">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-success-100">
                        <i class="ki-duotone ki-shield-tick text-2xl text-success">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <div class="flex-grow" style="width: 100%;">
                        <h4 class="text-success-700 font-medium mb-1">{{ __('admin.messages.success') }}</h4>
                        <p class="text-success-600 text-sm">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full hover:bg-success-200 transition-colors duration-200" onclick="this.closest('.alert').remove()">
                        <i class="ki-duotone ki-cross text-success-600 text-sm"></i>
                    </button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-5 mt-5 bg-danger-light border border-danger-200 rounded-xl shadow-lg animate-slideInDown" role="alert">
                <div class="flex items-center gap-4 p-4">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-danger-100">
                        <i class="ki-duotone ki-shield-cross text-2xl text-danger">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <div class="flex-grow" style="width: 100%;">
                        <h4 class="text-danger-700 font-medium mb-1">{{ __('admin.messages.error') }}</h4>
                        <p class="text-danger-600 text-sm">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full hover:bg-danger-200 transition-colors duration-200" onclick="this.closest('.alert').remove()">
                        <i class="ki-duotone ki-cross text-danger-600 text-sm"></i>
                    </button>
                </div>
            </div>
            @endif

            <!-- Content -->
            @yield('content')
            <!-- End of Content -->
            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/fecb87bdc5.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="{{ asset('js/lang.js') }}"></script> --}}
    <script>
        // Initialize translations
        // window.Lang = new Lang();
        // Lang.setLocale('{{ app()->getLocale() }}');
    </script>
    {{-- <script src="{{ asset('js/admin/cities.js') }}"></script> --}}
    @yield('scripts')
    <!-- End of Scripts -->
</body>

</html>
