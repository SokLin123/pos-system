<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />    
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        
        <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
        <link rel="stylesheet" href="assets/css/app.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="col-md-5 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-5  h-16">
                            <img src="assets/images/favicon.svg" class='mb-4 h-100 mx-auto'>
                            <h3>Sign In</h3>
                            <p>Please sign in to continue to Voler.</p>
                        </div>

                <div class="w-full sm:max-w-md mt-6 mx-auto px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
                <div class="divider">
                        <div class="divider-text">OR</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn flex btn-block mb-2 btn-primary"><i data-feather="facebook" class="me-2" ></i> Facebook</button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn flex btn-block mb-2 btn-secondary"><i data-feather="github" class="me-2" ></i> Github</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="assets/js/main.js"></script>
    </body>
</html>

