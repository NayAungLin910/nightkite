<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('/default_images/nightkite_logo_transparent.png') }}" />

    <title>@yield('meta-title', 'NightKite')</title>
    <meta name="description" content="@yield('meta-description', 'Visit the NightKite website and read informative content about physical and mental improvement topics for anyone. NightKite has got all the beneficial topics for you.')" />
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
    @viteReactRefresh
    @yield('custom-css')
</head>

<body>

    <!-- top nav bar -->
    <nav class="px-5 bg-slate-50 shadow md:flex md:items-center">
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
            class="ul-clear md:flex md:ml-3 md:items-center z-10 md:z-auto md:static absolute bg-slate-50 text-black left-0 w-full md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500 ">

            <!-- tags -->
            <li class="mx-3 py-5 md:mr-6 md:my-0 group/tags">
                <a href="#" class="text-xl text-black hover:no-underline group-hover/tags:text-cyan-500">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-tag"></i>
                        <span>
                            Tags
                        </span>
                    </div>
                </a>
                {{-- TagsSearch Component --}}
                <div id="tagSearch-app"
                    class="border hidden p-2 group-hover/tags:block md:absolute md:top-[4.2rem] rounded-lg shadow-md bg-white">
                </div>
                @vite('resources/js/tagsSearch.jsx')
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
                                <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.profile') }}">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-gauge"></i>
                                        Dashboard
                                    </div>
                                </a>
                            </li>
                            <li class="rounded-lg px-4 py-2 hover:bg-gray-100">
                                <form id="admin-logout-delete-form" action="{{ route('admin.dashboard.logout') }}" method="POST">
                                    @csrf
                                    <button type="button"
                                        onclick='openPopupDeleteSubmit("Are you sure about logging out form the account, {{ Auth::user()->name }}?", "admin-logout")'
                                        class="flex items-center gap-2">
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
                <span class="text-xl group-hover/search:text-sky-500">
                    Search Articles
                </span>
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

    <!-- delete popup -->
    <div class="bg-white duration-200 ease-in-out rounded-xl fixed top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] shadow-md w-full md:w-auto z-30 py-6 px-4 scale-0 border-t-8 border-orange-500"
        id="popup-delete">
        <p class="text-lg font-semibold text-center" id="popup-text-delete"></p>
        <div class="flex items-center gap-2 place-content-center mt-4">
            <button class="orange-button-rounded w-auto" onclick="closePopupDelete()">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </button>
            <button class="green-button-rounded w-auto" onclick="acceptPopupDelete()">
                <i class="fa-solid fa-check"></i>
                Accept
            </button>
        </div>
    </div>

    <!-- popup overlay delete -->
    <div class="duration-200 ease-in-out opacity-0 fixed top-0 left-0 bottom-0 right-0 bg-black/[0.5] z-20 pointer-events-none"
        id="popup-overlay-delete" onclick="closePopupDelete()">
    </div>

    <!-- toastify js -->
    <script async type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- show toast according to session -->
    @include('partials.session-popup')

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

    @include('partials.popup-delete')

    <!-- custom script -->
    @yield('custom-script')
</body>

</html>
