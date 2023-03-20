<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('/default_images/nightkite_logo_transparent.png') }}" />

    <title>@yield('meta-title', 'Admin Dashboard - NightKite')</title>
    <meta name="description" content="@yield('meta-description', 'The admin dashboard of NightKite article website is where advanced features are available and articles and categories can be created.')" />
    <link rel="canonical" href='@yield('meta-canonical', url()->current())' />
    <meta name="robots" content="@yield('meta-robots', 'index, follow')">

    <!-- Open Graph meta tags -->
    <meta property="og:type" content="@yield('meta-og-type', 'article')" />
    <meta property="og:title" content="@yield('meta-og-title', 'NightKite')" />
    <meta property="og:description" content="@yield('meta-og-description', 'The NightKite website admin dashboard, where articles can be written and advanced features can be used.')" />
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

    <!-- side bar toggle button -->
    <span class="absolute z-10 text-white text-4xl top-5 left-4 cursor-pointer block lg:hidden" onclick="openSidebar()">
        <span class="px-2 bg-gray-900 rounded-lg">
            <i class="fa-solid fa-bars"></i>
        </span>
    </span>

    <!-- side bar -->
    <div id="sidebar"
        class="fixed z-10 top-0 bottom-0 lg:left-0 left-[-300px] p-2 w-[300px] overflow-y-auto 
    text-center bg-slate-50 text-black shadow h-screen">
        <div class="text-dark text-xl">
            <div class="p-2.5 mt-1 flex items-center">
                <a href="{{ route('welcome') }}">
                    <img class="h-16" src="{{ asset('/default_images/nightkite_banner_transparent.webp') }}"
                        loading="lazy" alt="NightKite banner" />
                </a>
                <span class="ml-10 cursor-pointer lg:hidden text-black text-2xl" onclick="openSidebar()">
                    <i class="fa-solid fa-xmark"></i>
                </span>
            </div>

            <div class="flex items-center px-4 my-2 gap-2">
                <i class="fa-solid fa-gauge"></i>
                <h1>
                    Dashboard
                </h1>
            </div>

        </div>

        <hr class="my-2 text-gray-900" />

        <!-- back to site -->
        <a class="text-black hover:no-underline" href="{{ route('welcome') }}">
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-slate-50 hover:bg-slate-200 text-black">
                <span>
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span class="text-base ml-4 ">Back to Site</span>
            </div>
        </a>

        <!-- profile -->
        <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.profile') }}">
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-slate-200 text-black {{ request()->is('admin/dashboard/profile*') ? 'bg-slate-200' : 'bg-slate-50' }}">
                <span>
                    <i class="fa-solid fa-user"></i>
                </span>
                <span class="text-base ml-4">Profile</span>
            </div>
        </a>

        <hr class="my-4 text-gray-600" />

        <!-- admins account management -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer
            bg-slate-50 hover:bg-slate-200 text-black"
            onclick="dropdown('admins')">
            <span>
                <i class="fa-solid fa-users"></i>
            </span>
            <div class="flex justify-between w-full items-center">
                <span class="text-base ml-4">Admins</span>
                <span class="text-sm transition-all duration-500" id="admins-arrow">
                    <i
                        class="fa-solid fa-chevron-down {{ request()->is('admin/dashboard/accept-accounts*') || request()->is('admin/dashboard/search-account*') ? 'rotate-180' : '' }}"></i>
                </span>
            </div>
        </div>
        <div class="text-left mt-2 w-4/5 mx-auto text-dark {{ request()->is('admin/dashboard/accept-accounts*') || request()->is('admin/dashboard/search-account*') ? '' : 'hidden' }}"
            id="admins-submenu">
            @if (Auth::user()->role === '3')
                <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.accept-accounts') }}">
                    <div
                        class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/accept-accounts*') ? 'bg-slate-200' : '' }}">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-check"></i>
                            <span class="text-sm">
                                Accept Accounts
                            </span>
                        </div>
                    </div>
                </a>
            @endif
            <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.search-account') }}">
                <div
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/search-account*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="text-sm">
                            Search Admin Accounts
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- tags create, search and delete -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer
            bg-slate-50 hover:bg-slate-200 text-black"
            onclick="dropdown('tags')">
            <span>
                <i class="fa-solid fa-tag"></i>
            </span>
            <div class="flex justify-between w-full items-center">
                <span class="text-base ml-4">Tags</span>
                <span class="text-sm transition-all duration-500" id="tags-arrow">
                    <i
                        class="fa-solid fa-chevron-down {{ request()->is('admin/dashboard/tags*') ? 'rotate-180' : '' }}"></i>
                </span>
            </div>
        </div>
        <div class="text-left mt-2 w-4/5 mx-auto text-dark {{ request()->is('admin/dashboard/tags*') ? '' : 'hidden' }}"
            id="tags-submenu">
            <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.create-tags') }}">
                <div
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/tags/create*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span class="text-sm">
                            Create Tags
                        </span>
                    </div>
                </div>
            </a>
            <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.get-tags') }}">
                <div
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/tags/get*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="text-sm">
                            Search Tags
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- articles create, search and delete -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer
            bg-slate-50 hover:bg-slate-200 text-black"
            onclick="dropdown('articles')">
            <span>
                <i class="fa-solid fa-newspaper"></i>
            </span>
            <div class="flex justify-between w-full items-center">
                <span class="text-base ml-4">Articles</span>
                <span class="text-sm transition-all duration-500" id="articles-arrow">
                    <i
                        class="fa-solid fa-chevron-down {{ request()->is('admin/dashboard/article*') ? 'rotate-180' : '' }}"></i>
                </span>
            </div>
        </div>
        <div class="text-left mt-2 w-4/5 mx-auto text-dark {{ request()->is('admin/dashboard/article*') ? '' : 'hidden' }}"
            id="articles-submenu">
            <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.create-article') }}">
                <div
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/articles/create*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span class="text-sm">
                            Create Article
                        </span>
                    </div>
                </div>
            </a>
            <a class="text-black hover:no-underline" href="{{ route('admin.dashboard.search-article') }}">
                <div
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/articles/search*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="text-sm">
                            Search Articles
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <hr class="my-4 text-gray-600" />

    </div>

    <!-- custom content -->
    <main id="main-content" class="transition-all duration-500 lg:pl-[300px] z-0">
        @yield('custom-content')
    </main>

    <!-- popup -->
    <div class="bg-white duration-200 ease-in-out rounded-xl fixed top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] shadow-md w-full md:w-auto z-30 py-6 px-4 scale-0 border-t-8 border-green-500"
        id="popup">
        <p class="text-lg font-semibold text-center" id="popup-text"></p>
        <div class="flex items-center gap-2 place-content-center mt-4">
            <button class="orange-button-rounded w-auto" onclick="closePopup()">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </button>
            <button class="green-button-rounded w-auto" onclick="acceptPopup()">
                <i class="fa-solid fa-check"></i>
                Accept
            </button>
        </div>
    </div>

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

    <!-- popup overlay-->
    <div class="duration-200 ease-in-out opacity-0 fixed top-0 left-0 bottom-0 right-0 bg-black/[0.5] z-20 pointer-events-none"
        id="popup-overlay" onclick="closePopup()">
    </div>

    <!-- popup overlay delete -->
    <div class="duration-200 ease-in-out opacity-0 fixed top-0 left-0 bottom-0 right-0 bg-black/[0.5] z-20 pointer-events-none"
        id="popup-overlay-delete" onclick="closePopupDelete()">
    </div>

    <!-- toastify js -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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

    <!-- sidebar open/close toggle -->
    <script>
        function openSidebar() {
            document.querySelector('#sidebar').classList.toggle('left-[-300px]');
        }
    </script>

    <!-- sidebar dropdown toggle -->
    <script>
        function dropdown(type) {
            document.querySelector(`#${type}-submenu`).classList.toggle('hidden');
            document.querySelector(`#${type}-arrow`).classList.toggle('rotate-180');
        }
    </script>

    <!-- custom script -->
    @yield('custom-script')
</body>

</html>
