<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Styles -->
    <style>
        .faq-answer {
            overflow: hidden;
            transition: max-height 0.4s ease;
            max-height: 0;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    <header class="absolute inset-x-0 top-0 z-50">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between p-6 lg:px-8 bg-gray-900/75" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                            alt="">
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-100"
                        aria-label="Open main menu">
                        <span class="sr-only">Open main menu</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#About" class="text-sm/6 font-semibold text-gray-100">About</a>
                    <a href="#Contact" class="text-sm/6 font-semibold text-gray-100">Contact</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-100">FAQ</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm/6 font-semibold text-gray-100">Dashboard <span
                                aria-hidden="true">&rarr;</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-gray-100">Log in
                            |</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-1 text-sm/6 font-semibold text-gray-100">Register
                            </a>
                        @endif
                    @endauth
                </div>

            </nav>
        @endif
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div
                class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                            alt="">
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" aria-label="Close menu">
                        <span class="sr-only">Close menu</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#About"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-100 hover:bg-gray-50">About</a>
                            <a href="#Contact"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-100 hover:bg-gray-50">Contact</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-100 hover:bg-gray-50">FAQ</a>
                        </div>
                        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm/6 font-semibold text-gray-100">Dashboard
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-gray-100">Log in
                                    |</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-1 text-sm/6 font-semibold text-gray-100">Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="relative isolate overflow-hidden py-24 sm:py-32">
        <div class="absolute inset-0 -z-10 w-full h-full overflow-hidden">
            <img src="{{ asset('img/highway.jpg') }}" alt=""
                class="absolute inset-0 -z-10 w-full h-full object-cover object-right md:object-center">
        </div>
        <div class="mx-auto max-w-7xl p-8 lg:p-10 bg-gray-900/75 rounded-lg ">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-5xl font-semibold tracking-tight text-white sm:text-7xl">Work with us</h2>
                <p class="mt-8 text-lg font-medium text-pretty text-gray-300 sm:text-xl/8">Anim aute id magna
                    aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat
                    veniam occaecat fugiat.</p>
            </div>
            <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
                <div
                    class="grid grid-cols-1 gap-x-8 gap-y-6 text-base/7 font-semibold text-white sm:grid-cols-2 md:flex lg:gap-x-10">
                    <a href="#">Open roles <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Internship program <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Our values <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Meet our leadership <span aria-hidden="true">&rarr;</span></a>
                </div>
                <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Offices worldwide</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">12</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Full-time colleagues</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">300+</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Hours per week</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">40</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Paid time off</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">Unlimited</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    {{-- About --}}
    <div id="About"
        class="relative isolate overflow-hidden bg-white px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ asset('img/tire.jpg') }}" alt=""
                class="absolute inset-0 -z-10 h-full w-full object-cover object-right md:object-center">
        </div>
        <div
            class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
            <div
                class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <div class="lg:max-w-lg">
                        <p class="text-base/7 font-semibold text-indigo-600">Over ons</p>
                        <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">
                            Rijschool Vierkante Wielen</h1>
                        <p class="mt-6 text-xl/8 text-gray-700">Bij Rijschool Vierkante Wielen geloven we dat iedereen
                            de kans verdient om veilig en zelfverzekerd de weg op te gaan. Met onze ervaren instructeurs
                            en persoonlijke aanpak zorgen we ervoor dat jij je rijbewijs haalt op een manier die bij jou
                            past.</p>
                    </div>
                </div>
            </div>
            <div
                class="-mt-12 -ml-12 p-12 lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                <img class="w-[48rem] max-w-none rounded-xl bg-gray-900 shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem]"
                    src="{{ asset('img/driving_lesson.jpg') }}"
                    alt="Rijschool Vierkante Wielen instructeur en leerling">
            </div>
            <div
                class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <div class="max-w-xl text-base/7 text-gray-700 lg:max-w-lg">
                        <p>Onze rijschool biedt een breed scala aan diensten, van reguliere rijlessen tot intensieve
                            cursussen en opfrislessen. Of je nu een beginnende bestuurder bent of je vaardigheden wilt
                            verbeteren, wij hebben een programma dat bij jou past.</p>
                        <ul role="list" class="mt-8 space-y-8 text-gray-600">
                            <li class="flex gap-x-3">
                                <span><strong class="font-semibold text-gray-900">Persoonlijke begeleiding.</strong>
                                    Onze instructeurs passen zich aan jouw leertempo aan, zodat je altijd comfortabel en
                                    zelfverzekerd achter het stuur zit.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6 flex-none text-indigo-600" aria-hidden="true">
                                    <path
                                        d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                                    <path
                                        d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                                    <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                </svg>

                                <span><strong class="font-semibold text-gray-900">Moderne voertuigen.</strong> Onze
                                    auto's zijn uitgerust met de nieuwste technologieën om jouw leerervaring veilig en
                                    efficiënt te maken.</span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6 flex-none text-indigo-600" aria-hidden="true">
                                    <path
                                        d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                    <path fill-rule="evenodd"
                                        d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span><strong class="font-semibold text-gray-900">Flexibele lestijden.</strong> Wij
                                    begrijpen dat iedereen een druk schema heeft. Daarom bieden we lessen aan op tijden
                                    die jou uitkomen.</span>
                            </li>
                        </ul>
                        <p class="mt-8">Bij Rijschool Vierkante Wielen draait alles om jou. We streven ernaar om van
                            elke les een leerzame en plezierige ervaring te maken. Samen zorgen we ervoor dat jij met
                            vertrouwen de weg op gaat.</p>
                        <h2 class="mt-16 text-2xl font-bold tracking-tight text-gray-900">Waarom kiezen voor ons?</h2>
                        <p class="mt-6">Met jarenlange ervaring en een bewezen succesratio zijn wij de rijschool waar
                            je op kunt vertrouwen. Onze leerlingen waarderen onze geduldige aanpak en ons vermogen om
                            zelfs de meest nerveuze bestuurders op hun gemak te stellen.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Onze diensten --}}
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-center text-base/7 font-semibold text-indigo-600">Onze diensten</h2>
            <p
                class="mx-auto mt-2 max-w-lg text-center text-4xl font-semibold tracking-tight text-balance text-gray-950 sm:text-5xl">
                Alles wat je nodig hebt om jouw doelen te bereiken</p>
            <div class="mt-10 grid gap-4 sm:mt-16 lg:grid-cols-3 lg:grid-rows-2">
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white lg:rounded-l-[2rem]"></div>
                    <div
                        class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">
                                Persoonlijke begeleiding</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Onze instructeurs
                                passen zich aan jouw leertempo aan, zodat je altijd comfortabel en zelfverzekerd achter
                                het stuur zit.</p>
                        </div>
                        <div class="@container relative min-h-[30rem] w-full grow max-lg:mx-auto max-lg:max-w-sm">
                            <div
                                class="absolute inset-x-10 top-10 bottom-0 overflow-hidden rounded-t-[12cqw] border-x-[3cqw] border-t-[3cqw] border-gray-700 bg-gray-900 shadow-2xl">
                                <img class="size-full object-cover object-top"
                                    src="{{ asset('img/personal_guidance.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div
                        class="pointer-events-none absolute inset-px rounded-lg shadow-sm ring-1 ring-black/5 lg:rounded-l-[2rem]">
                    </div>
                </div>
                <div class="relative max-lg:row-start-1">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-t-[2rem]"></div>
                    <div
                        class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Moderne
                                voertuigen</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Onze auto's zijn
                                uitgerust met de nieuwste technologieën om jouw leerervaring veilig en efficiënt te
                                maken.</p>
                        </div>
                        <div
                            class="flex flex-1 items-center justify-center px-8 max-lg:pt-10 max-lg:pb-12 sm:px-10 lg:pb-2 shadow-2xl">
                            <img class="w-full max-lg:max-w-xs rounded-lg shadow-2xl shadow-indigo-600/50 shadow-[10px_10px_20px_rgba(0,0,0,0.25)]"
                                src="{{ asset('img/modern_vehicles.jpg') }}" alt="">
                        </div>
                    </div>
                    <div
                        class="pointer-events-none absolute inset-px rounded-lg shadow-sm ring-1 ring-black/5 max-lg:rounded-t-[2rem]">
                    </div>
                </div>
                <div class="relative max-lg:row-start-3 lg:col-start-2 lg:row-start-2">
                    <div class="absolute inset-px rounded-lg bg-white"></div>
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">
                                Flexibele lestijden</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Wij bieden lessen aan
                                op tijden die jou uitkomen, zodat je je rijlessen kunt plannen rond jouw drukke schema.
                            </p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img class="h-[min(152px,40cqw)] object-cover"
                                src="{{ asset('img/flexible_schedule.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm ring-1 ring-black/5"></div>
                </div>
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]">
                    </div>
                    <div
                        class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">
                                Intensieve cursussen</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Voor degenen die snel
                                hun rijbewijs willen halen, bieden we intensieve cursussen aan die zijn afgestemd op
                                jouw behoeften.</p>
                        </div>
                        <div class="relative min-h-[30rem] w-full grow">
                            <div
                                class="absolute top-10 right-0 bottom-0 left-10 overflow-hidden rounded-tl-xl bg-gray-900 shadow-2xl">
                                <img class="size-full object-cover" src="{{ asset('img/intensive_courses.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div
                        class="pointer-events-none absolute inset-px rounded-lg shadow-sm ring-1 ring-black/5 max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]">
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Contact --}}
    <div id="Contact" class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8 relative">
        <div class="absolute inset-0 -z-10 w-full h-full overflow-hidden">
            <img src="{{ asset('img/gear.jpg') }}" alt=""
                class="absolute inset-0 -z-10 w-full h-full object-cover object-right md:object-center opacity-30">
        </div>
        {{-- <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]"
            aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-1155/678 w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff9800] to-[#f44336] opacity-40 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div> --}}
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Contact ons</h2>
            <p class="mt-2 text-lg/8 text-gray-600">Neem gerust contact met ons op voor al uw vragen en opmerkingen.
                Wij staan klaar om u te helpen!</p>
        </div>
        <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="first-name" class="block text-sm/6 font-semibold text-gray-900">Voornaam</label>
                    <div class="mt-2.5">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                            class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    </div>
                </div>
                <div>
                    <label for="last-name" class="block text-sm/6 font-semibold text-gray-900">Achternaam</label>
                    <div class="mt-2.5">
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                            class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    </div>
                </div>
                {{-- <div class="sm:col-span-2">
                    <label for="company" class="block text-sm/6 font-semibold text-gray-900">Company</label>
                    <div class="mt-2.5">
                        <input type="text" name="company" id="company" autocomplete="organization"
                            class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    </div>
                </div> --}}
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
                    <div class="mt-2.5">
                        <input type="email" name="email" id="email" autocomplete="email"
                            class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="phone-number" class="block text-sm/6 font-semibold text-gray-900">Tel.nr</label>
                    <div class="mt-2.5">
                        <div
                            class="flex rounded-md bg-white outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                <select id="country" name="country" autocomplete="country" aria-label="Country"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-2 pr-7 pl-3.5 text-base text-gray-500 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    <option>US</option>
                                    <option>CA</option>
                                    <option>EU</option>
                                </select>
                                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                    viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="phone-number" id="phone-number"
                                class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                placeholder="123-456-7890">
                        </div>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm/6 font-semibold text-gray-900">Opmerking</label>
                    <div class="mt-2.5">
                        <textarea name="message" id="message" rows="4"
                            class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
                    </div>
                </div>
                <div class="flex gap-x-4 sm:col-span-2">
                    <div class="flex h-6 items-center">
                        <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                        <button type="button"
                            class="flex w-8 flex-none cursor-pointer rounded-full bg-gray-200 p-px ring-1 ring-gray-900/5 transition-colors duration-200 ease-in-out ring-inset focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            role="switch" aria-checked="false" aria-labelledby="switch-1-label">
                            <span class="sr-only">Agree to policies</span>
                            <!-- Enabled: "translate-x-3.5", Not Enabled: "translate-x-0" -->
                            <span aria-hidden="true"
                                class="size-4 translate-x-0 transform rounded-full bg-white shadow-xs ring-1 ring-gray-900/5 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                    <label class="text-sm/6 text-gray-600" id="switch-1-label">
                        Door dit te selecteren, ga je akkoord met ons
                        <a href="#" class="font-semibold text-indigo-600">privacybeleid</a>.
                    </label>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit"
                    class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's
                    talk</button>
            </div>
        </form>
    </div>

    {{-- Instructors --}}
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl gap-20 px-6 lg:px-8 xl:grid-cols-3">
            <div class="max-w-xl">
                <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Meet our
                    leadership</h2>
                <p class="mt-6 text-lg/8 text-gray-600">We’re a dynamic group of individuals who are passionate about
                    what we do and dedicated to delivering the best results for our clients.</p>
            </div>
            <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
                <li>
                    <div class="flex items-center gap-x-6">
                        <img class="size-16 rounded-full"
                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                        <div>
                            <h3 class="text-base/7 font-semibold tracking-tight text-gray-900">Leslie Alexander</h3>
                            <p class="text-sm/6 font-semibold text-indigo-600">Co-Founder / CEO</p>
                        </div>
                    </div>
                </li>

                <!-- More people... -->
            </ul>
        </div>
    </div>


    {{-- FAQ --}}
    <section class="w-full px-4 sm:px-6 lg:px-8 py-10 relative">
        <div class="absolute inset-0 -z-10 w-full h-full overflow-hidden">
            <img src="{{ asset('img/white_stripe.jpg') }}" alt=""
                class="absolute inset-0 -z-10 w-full h-full object-cover object-right md:object-center">
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Veelgestelde vragen</h2>
        <p class="text-gray-600 mb-8 text-base sm:text-lg text-center">
            Staat je vraag er niet tussen? Neem contact op met onze
            <a href="#" class="text-blue-600 hover:underline">klantenservice</a>.
        </p>

        <div class="space-y-6 max-w-4xl mx-auto">
            <!-- FAQ items -->
            <div class="border-b pb-4">
                <button
                    class="faq-toggle w-full text-left font-semibold flex justify-between items-center text-base sm:text-lg cursor-pointer">
                    <span>Hoeveel kost een rijles bij Rijschool Vierkante Wielen?</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer text-gray-600 mt-2 text-sm sm:text-base">
                    <p class="pt-2">De kosten voor een rijles bedragen €50 per uur. We bieden ook pakketten aan met
                        korting.</p>
                </div>
            </div>

            <div class="border-b pb-4">
                <button
                    class="faq-toggle w-full text-left font-semibold flex justify-between items-center text-base sm:text-lg cursor-pointer">
                    <span>Hoe kan ik me inschrijven voor rijlessen?</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer text-gray-600 mt-2 text-sm sm:text-base">
                    <p class="pt-2">Je kunt je inschrijven via onze website of door contact op te nemen met onze
                        klantenservice.</p>
                </div>
            </div>

            <div class="border-b pb-4">
                <button
                    class="faq-toggle w-full text-left font-semibold flex justify-between items-center text-base sm:text-lg cursor-pointer">
                    <span>Hoeveel lessen heb ik gemiddeld nodig om mijn rijbewijs te halen?</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer text-gray-600 mt-2 text-sm sm:text-base">
                    <p class="pt-2">Gemiddeld hebben leerlingen tussen de 30 en 40 lessen nodig, afhankelijk van hun
                        ervaring en vaardigheden.</p>
                </div>
            </div>

            <div class="border-b pb-4">
                <button
                    class="faq-toggle w-full text-left font-semibold flex justify-between items-center text-base sm:text-lg cursor-pointer">
                    <span>Bieden jullie een proefles aan?</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer text-gray-600 mt-2 text-sm sm:text-base">
                    <p class="pt-2">Ja, we bieden een proefles aan voor €25. Dit bedrag wordt verrekend als je
                        besluit door te gaan met lessen.</p>
                </div>
            </div>

            <div class="border-b pb-4">
                <button
                    class="faq-toggle w-full text-left font-semibold flex justify-between items-center text-base sm:text-lg cursor-pointer">
                    <span>Kan ik mijn rijlessen annuleren of verplaatsen?</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer text-gray-600 mt-2 text-sm sm:text-base">
                    <p class="pt-2">Ja, je kunt je lessen tot 24 uur van tevoren annuleren of verplaatsen zonder
                        extra kosten.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 shadow">
        <div class="w-full mx-auto p-4 sm:p-6 lg:p-8 max-w-none">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <a href="#" class="flex items-center">
                        <svg class="h-8 w-auto text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C9 7 3 9 0 9c3 0 9 2 12 9 3-7 9-9 12-9-3 0-9-2-12-9z" />
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-4">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-600 uppercase">Solutions</h2>
                        <ul class="text-gray-400">
                            <li><a href="#" class="hover:underline">Marketing</a></li>
                            <li><a href="#" class="hover:underline">Analytics</a></li>
                            <li><a href="#" class="hover:underline">Automation</a></li>
                            <li><a href="#" class="hover:underline">Commerce</a></li>
                            <li><a href="#" class="hover:underline">Insights</a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-600 uppercase">Support</h2>
                        <ul class="text-gray-400">
                            <li><a href="#" class="hover:underline">Submit ticket</a></li>
                            <li><a href="#" class="hover:underline">Documentation</a></li>
                            <li><a href="#" class="hover:underline">Guides</a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-600 uppercase">Company</h2>
                        <ul class="text-gray-400">
                            <li><a href="#" class="hover:underline">About</a></li>
                            <li><a href="#" class="hover:underline">Blog</a></li>
                            <li><a href="#" class="hover:underline">Jobs</a></li>
                            <li><a href="#" class="hover:underline">Press</a></li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-600 uppercase">Legal</h2>
                        <ul class="text-gray-400">
                            <li><a href="#" class="hover:underline">Terms of service</a></li>
                            <li><a href="#" class="hover:underline">Privacy policy</a></li>
                            <li><a href="#" class="hover:underline">License</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-6 sm:mt-10 border-t border-gray-200 pt-6 sm:pt-10">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <form class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <label for="email" class="sr-only">Email address</label>
                            <input type="email" id="email"
                                class="w-full sm:w-auto px-4 py-2 border border-white rounded-md text-color-gray-500 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                placeholder="Enter your email" />
                            <button type="submit"
                                class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 cursor-pointer">Subscribe</button>
                        </form>
                    </div>
                    <div class="flex mt-4 sm:mt-0 space-x-6 text-xl">
                        <a href="#" class="text-gray-100 hover:text-gray-900"><i
                                class="fab fa-facebook-f cursor-pointer"></i></a>
                        <a href="#" class="text-gray-100 hover:text-gray-900"><i
                                class="fab fa-instagram cursor-pointer"></i></a>
                        <a href="#" class="text-gray-100 hover:text-gray-900"><i
                                class="fab fa-twitter cursor-pointer"></i></a>
                        <a href="#" class="text-gray-100 hover:text-gray-900"><i
                                class="fab fa-github cursor-pointer"></i></a>
                        <a href="#" class="text-gray-100 hover:text-gray-900"><i
                                class="fab fa-youtube cursor-pointer"></i></a>
                    </div>
                </div>
                <p class="mt-6 text-sm text-gray-500 text-center sm:text-left">
                    © 2024 Your Company, Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.querySelector('button[aria-label="Open main menu"]');
            const closeButton = document.querySelector('button[aria-label="Close menu"]');
            const mobileMenu = document.querySelector('div[role="dialog"]');

            // Ensure the menu is closed by default
            mobileMenu.style.display = 'none';

            menuButton.addEventListener('click', () => {
                mobileMenu.style.display = 'block';
            });

            closeButton.addEventListener('click', () => {
                mobileMenu.style.display = 'none';
            });
        });
    </script>
    <script>
        const toggles = document.querySelectorAll('.faq-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const answer = toggle.nextElementSibling;
                const icon = toggle.querySelector('svg');
                const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

                document.querySelectorAll('.faq-answer').forEach(el => {
                    el.style.maxHeight = null;
                });
                document.querySelectorAll('.faq-toggle svg').forEach(el => {
                    el.classList.remove('rotate-180');
                });

                if (!isOpen) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>
</body>

</html>
