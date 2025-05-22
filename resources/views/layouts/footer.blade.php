<footer class="bg-white dark:bg-gray-900 py-8 w-full flex justify-center">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-gray-600 dark:text-gray-100 text-lg font-semibold mb-4">Rijschool Vierkantewielen</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Rijschool Vierkantewielen is een professionele
                    rijschool die zich richt
                    op het leveren van kwalitatief hoogwaardige rijopleiding. Wij streven ernaar om onze leerlingen op
                    een veilige en effectieve manier klaar te stomen voor het behalen van hun rijbewijs.</p>
            </div>
            <div>
                <h3 class="text-gray-600 dark:text-gray-100 text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="text-gray-600 dark:text-gray-300 text-sm">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/#About') }}">Over ons</a></li>
                    <li><a href="{{ url('/#Contact') }}">Contact</a></li>
                    <li><a href="{{ url('/#instructors') }}">Instrukteurs</a></li>
                    <li><a href="{{ url('/#FAQ') }}">Veel gestelde vragen</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-600 dark:text-gray-100">Neem Contact op</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">123 Main Street<br>Springfield, IL 62701<br>Phone:
                    (555) 555-5555
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-600 dark:text-gray-100">Volg ons</h3>
                <div class="flex flex-col space-y-4">
                    <a href="https://facebook.com" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        👑
                    </a>
                    <a href="#" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        💼
                    </a>
                    <a href="#" target="_blank"
                        class="text-xl text-white hover:text-gray-300 transition duration-300">
                        🌐
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-8 text-gray-600 dark:text-gray-100">
            <p>&copy; {{ date('Y') }} Rijschool Vierkantewielen. Alle rechten voorbehouden.</p>
        </div>
    </div>
</footer>
