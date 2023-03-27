<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('/default_images/nightkite_logo_transparent.png') }}" />

    <title>@yield('meta-title', 'NightKite')</title>
    <meta name="description" content="@yield('meta-description', 'Give a visit and read informative content about physical and mental improvement topics for anyone. NightKite has got all the beneficial topics for you.')" />
    <link rel="canonical" href='@yield('meta-canonical', url()->current())' />
    <meta name="robots" content="@yield('meta-robots', 'index, follow')">

    <!-- Open Graph meta tags -->
    <meta property="og:type" content="@yield('meta-og-type', 'article')" />
    <meta property="og:title" content="@yield('meta-og-title', 'NightKite')" />
    <meta property="og:description" content="@yield('meta-og-description', 'NightKite is an informative website covering topics on how to improve the physical and mental strength of anyone.')" />
    <meta property="og:image" content="@yield('meta-og-image', asset('/default_images/nightkite_banner.png'))" />
    <meta property="og:url" content="@yield('meta-og-url', url()->current())" />
    <meta property="og:site_name" content="@yield('meta-og-sitename', 'NightKite')" />

    <!-- toastify css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- tailwindcss -->
    @vite('resources/js/app.js')

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->
    @yield('custom-css')
</head>

<body>

    <!-- top nav bar -->
    <nav class="px-5 bg-white shadow md:flex md:items-center">
        <div class="flex justify-between items-center">
            <span class="text-2xl">
                <a href="{{ url('/') }}">
                    <img class="h-14 inline" src="{{ asset('/default_images/nightkite_banner.webp') }}"
                        alt="NightKite banner" loading="lazy" />
                </a>
            </span>

            <!-- navbar toggle button -->
            <span class="text-3xl cursor-pointer mx-2 md:hidden block">
                <i class="fa-solid fa-bars" onclick="toggleMenu(this)"></i>
            </span>
        </div>
        <ul id="top-nav-ul"
            class="ul-clear md:flex md:ml-3 md:items-center z-10 md:z-auto md:static absolute bg-slate-50 text-black md:bg-white left-0 w-full md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500 ">

            <!-- tags -->
            <li class="mx-3 my-5 md:my-0">
                <a href="#" class="text-xl text-black hover:no-underline hover:text-cyan-500 duration-500">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-tag"></i>
                        <span>
                            Tags
                        </span>
                    </div>
                </a>
            </li>

            <!-- if auth -->
            @if (Auth::check())
                <li class="mx-3 my-5 md:my-0">
                    <button class=" cursor-pointer" onclick="dropdownToggle('profile')">
                        <img src="{{ Auth::user()->image }}" class="w-10 border rounded-full shadow" loading="lazy"
                            alt="{{ Auth::user()->name }}'s profile image" />
                    </button>
                    <div id="profile-dropdown"
                        class="hidden md:absolute rounded-lg w-auto bg-white text-black shadow py-2 px-1">
                        <ul class="ul-clear">
                            <li class="rounded-lg cursor-pointer px-4 py-2 hover:bg-gray-100">
                                <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.home') }}">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-gauge"></i>
                                        Dashboard
                                    </div>
                                </a>
                            </li>
                            <li class="rounded-lg cursor-pointer px-4 py-2 hover:bg-gray-100">
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" form="logout-form" class="flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            <!-- search -->
            <li class="mx-3 py-5 md:pr-14 md:my-0 group/search">
                <i class="fa-solid fa-magnifying-glass text-lg cursor-pointer group-hover/search:text-sky-500"></i>
                <div
                    class="border hidden px-3 py-3 group-hover/search:block md:absolute md:top-[4.5rem] rounded-lg shadow-md bg-white">
                    <form action="{{ route('article.search') }}">
                        <div class="flex items-center gap-3">
                            <input type="text" autocomplete="off" name="search" class="input-form-sky">
                            <button type="submit" class="sky-button-rounded px-2 py-1 ">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- custom content -->
    <main id="main-content" class="transition-all duration-500">
        @yield('custom-content')
    </main>

    <!-- toastify js -->
    <script async type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- show toast according to session -->
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "",
                newWindow: true,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #F12F26, #F06D67)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                destination: "",
                newWindow: true,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 3000,
                destination: "",
                newWindow: true,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #0978EE, #6EADEF)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif

    <!-- top nav bar menu toggle on mobile view -->
    <script>
        function toggleMenu(e) {
            let list = document.getElementById('top-nav-ul');
            let main = document.getElementById('main-content');

            e.className === "fa-solid fa-bars" ?
                (
                    e.className = "fa-solid fa-xmark",
                    list.classList.add('top-[59px]'),
                    list.classList.add('opacity-95')
                ) : (
                    e.className = "fa-solid fa-bars",
                    list.classList.remove('top-[59px]'),
                    list.classList.remove('opacity-95')
                );
        }

        // dropdown toggle
        function dropdownToggle(type) {
            let dropdownList = document.getElementById(`${type}-dropdown`);

            dropdownList.classList.toggle('hidden');
        }
    </script>

    <!-- custom script -->
    @yield('custom-script')
</body>

</html>
