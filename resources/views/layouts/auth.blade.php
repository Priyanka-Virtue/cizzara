<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>The Universal Product</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    <style>
        nav svg {
            max-width: 25px !important;
        }
    </style>
    @yield('head')
</head>

<body>
    <div class="position-relative">

        <div class="pt-5">
            @if($step ?? null)
            @include('partials.steps', ['active' => $step])
            @endif
        </div>
        <div class="authentication-wrapper authentication-basic container-p-y pt-0">

            <div class="justify-content-center d-flex {{$width ?? 'col-6'}}">
                <div class="authentication-inner py-4">

                    <!-- Register Card -->
                    <div class="card p-2">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mt-5">
                            <a href="#" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <img class="invert" src="{{ asset('images/logo-or.png') }}" width="190px" alt="{{ config('app.name', 'The United Production') }}">
                                </span>
                            </a>

                        </div>
                        <!-- /Logo -->
                        <div class="card-body mt-2">
                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if($form_title ?? null)
                            <h4 class="mb-2">{{$form_title}}</h4>
                            <p class="mb-4">{{$form_description}}</p>
                            @endif
                            @yield('content')

                        </div>
                    </div>
                    <!-- Register Card -->
                    <img src="../assets/img/illustrations/tree-3.png" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block hue" />
                    <img src="../assets/img/illustrations/auth-basic-mask-light.png" class="authentication-image d-none d-lg-block hue" alt="triangle-bg" data-app-light-img="illustrations/auth-basic-mask-light.png" data-app-dark-img="illustrations/auth-basic-mask-dark.png" />
                    <img src="../assets/img/illustrations/tree.png" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block hue" />
                </div>
            </div>
        </div>
    </div>



    <div class="buy-now" style="display: none;">
        <a href="https://themeselection.com/item/materio-bootstrap-html-admin-template/" rel="no-follow">Upgrade to Pro</a>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

    @yield('bottom')
</body>

</html>
