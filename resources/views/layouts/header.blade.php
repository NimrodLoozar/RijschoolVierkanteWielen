<header class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-1 py-1 bg-sky-400 custom-shadow">
    <div class="flex">
        <a href="{{ url('/') }}"><img class="h-14 w-auto mr-6 ml-6" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&amp;shade=600"></a>
        <div>
            <h1 class="text-2xl font-bold">Rijschool Vierkantewielen</h1>
            <p class="text-sm italic">Uw rid, onze instructie</p>
        </div>
        <a href="{{ url('') }}" class="ml-6 mt-3 text-lg font-semibold text-black hover:text-gray-600">placeholder</a>
        <a href="{{ url('') }}" class="ml-6 mt-3 text-lg font-semibold text-black hover:text-gray-600">placeholder</a>
        <a href="{{ url('') }}" class="ml-6 mt-3 text-lg font-semibold text-black hover:text-gray-600">placeholder</a>
        <a href="{{ url('') }}" class="ml-6 mt-3 text-lg font-semibold text-black hover:text-gray-600">placeholder</a>
        </div>
    @if (Route::has('login'))
        <nav class="flex"></nav>
        @auth
            <a href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-black ring-1 text-lg ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                Dashboard
            </a>
        @else
            <div>
                <a href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                        Register
                    </a>
            </div>
        @endif
    @endauth
    </nav>
    @endif
    <div id="progress-bar" class="absolute bottom-0 left-0 h-1 bg-red-500 w-0"></div>
</header>
<script>
    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        document.getElementById('progress-bar').style.width = scrollPercent + '%';
    });
</script>
