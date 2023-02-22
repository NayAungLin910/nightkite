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
    @vite('resources/css/app.css')

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
    text-center bg-slate-50 text-black shadow">
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
                <h1 class="">
                    Dashboard
                </h1>
            </div>

            <hr class="my-2 text-gray-900" />
        </div>

        <!-- back to site -->
        <a href="{{ route('welcome') }}">
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-slate-50 hover:bg-slate-200 text-black">
                <span>
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span class="text-base ml-4">Back to Site</span>
            </div>
        </a>

        <div
            class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-slate-50 hover:bg-slate-200 text-black">
            <span>
                <i class="fa-solid fa-bookmark"></i>
            </span>
            <span class="text-base ml-4">Bookmark</span>
        </div>

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
                <a href="{{ route('admin.dashboard.accept-accounts') }}">
                    <h1
                        class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/accept-accounts*') ? 'bg-slate-200' : '' }}">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-check"></i>
                            <span class="text-sm">
                                Accept Accounts
                            </span>
                        </div>
                    </h1>
                </a>
            @endif
            <a href="{{ route('admin.dashboard.search-account') }}">
                <h1
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/search-account*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="text-sm">
                            Search Admin Accounts
                        </span>
                    </div>
                </h1>
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
            <a href="{{ route('admin.dashboard.create-tags') }}">
                <h1
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/tags/create*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span class="text-sm">
                            Create Tags
                        </span>
                    </div>
                </h1>
            </a>
            <a href="{{ route('admin.dashboard.get-tags') }}">
                <h1
                    class="cursor-pointer p-2 hover:bg-slate-200 rounded-md mt-1 duration-500 {{ request()->is('admin/dashboard/tags/get*') ? 'bg-slate-200' : '' }}">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="text-sm">
                            Search Tags
                        </span>
                    </div>
                </h1>
            </a>
        </div>

    </div>

    <!-- custom content -->
    <main id="main-content" class="transition-all duration-500 lg:pl-[300px] z-0">
        @yield('custom-content')
    </main>

    <!-- popup -->
    <div class=" bg-white duration-200 ease-in-out rounded-xl fixed top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] border shadow-md w-full md:w-auto z-30 py-6 px-4 scale-0"
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

    <!-- popup overlay-->
    <div class="duration-200 ease-in-out opacity-0 fixed top-0 left-0 bottom-0 right-0 bg-black/[0.5] z-20 pointer-events-none"
        id="popup-overlay" onclick="closePopup()">
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

    <!-- top nav bar menu toggle on mobile view -->
    <script>
        function toggleMenu(e) {
            let list = document.getElementById('top-nav-ul');
            let main = document.getElementById('main-content');

            e.className === "fa-solid fa-bars" ?
                (
                    e.className = "fa-solid fa-xmark",
                    list.classList.add('top-[65px]'),
                    list.classList.add('opacity-70'),
                    main.classList.add('blur-sm')
                ) : (
                    e.className = "fa-solid fa-bars",
                    list.classList.remove('top-[65px]'),
                    list.classList.remove('opacity-70'),
                    main.classList.remove('blur-sm')
                );
        }
    </script>

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

    <!-- popup open, close, submit and cancel -->
    <script>
        let email = ""; // global email variable
        let type = ""; // submit or delete

        // open popup and display
        function openPopupSubmit(text, email, type) {
            document.querySelector(`#popup-overlay`).classList.toggle('active'); // show popup overlay
            document.querySelector(`#popup`).classList.toggle('active'); // show popup
            document.querySelector(`#popup-text`).innerHTML = text; // show the given popup text

            this.email = email; // assign email to global email variable
            this.type = type;
        }

        // accept popup
        function acceptPopup() {
            switch (this.type) {
                case 'submit':
                    document.getElementById(`${this.email}-accept-form`).submit(); // submit the given form 
                    break;
                case 'delete':
                    document.getElementById(`${this.email}-delete-form`).submit(); // submit the given form 
                    break;
                default:
                    console.log('Popup type was not found!');
            }

            document.querySelector(`#popup`).classList.toggle('active'); // close popup 
            document.querySelector(`#popup-overlay`).classList.toggle('active'); // close popup overlay
        }

        // close popup
        function closePopup() {
            document.querySelector(`#popup`).classList.toggle('active'); // close popup
            document.querySelector(`#popup-overlay`).classList.toggle('active'); // close popup overlay
        }
    </script>

    <!-- custom script -->
    @yield('custom-script')
</body>

</html>
