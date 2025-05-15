<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TravelEasy</title>
    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Protest+Guerrilla&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Styles / Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-shadow {
            box-shadow: 5px 5px 15px rgba(0, 0, 0, .5);
        }

        .tab-label {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .tab-label.active {
            font-size: 1.25rem;
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="font-sans bg-white antialiased text pt-16">
    <x-header-layout />
    {{ $slot }}
    <x-footer-layout />
</body>

</html>
