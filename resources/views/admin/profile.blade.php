@extends('layout.master-dashboard')
@section('meta-title', 'Profile of the Logined Admin - NightKite')
@section('meta-description', 'View the various information of the logined admin.')
@section('meta-og-title', "Admin Profile Page - NightKite")
@section('meta-og-description', "Check the various information of the currently logined admin account from this page.")

@section('custom-content')

    <div class="m-2 mt-6">
        <h1 class="text-xl text-center">
            @if (Auth::user()->role === '3')
                <span
                    class="w-[6rem] py-1 px-2 text-sm text-white bg-indigo-500 whitespace-nowrap rounded-lg text-center shadow-md">
                    Super Admin</span>
            @elseif (Auth::user()->role === '2')
                <span
                    class="w-[4rem] py-1 px-2 text-sm text-white bg-green-500 whitespace-nowrap rounded-lg text-center shadow-md">
                    Admin</span>
            @endif
            {{ Auth::user()->name }}
        </h1>
        <div class="mt-10 mb-4 flex items-center">
            <div class="rounded-lg px-6 py-4 shadow-lg mx-auto">
                <table class="table-auto border-collapse">
                    <tr>
                        <td class="px-2 py-1 w-auto font-normal whitespace-nowrap">
                            <i class="fa-solid fa-envelope"></i>
                            <span>Email</span>
                        </td>
                        <td class="px-2 py-1 w-auto font-normal whitespace-nowrap">
                            <span id="email-info">{{ Auth::user()->email }}</span>
                            <i id="email-copy" onclick="copyText('email')" class="fa-solid fa-copy cursor-pointer ml-2"></i>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('custom-script')

    <!-- let the user copy the related text -->
    <script>
        async function copyText(type) {
            let text = document.getElementById(`${type}-info`).innerHTML; // get the related text

            try {
                await navigator.clipboard.writeText(text);

                // show toast after copied
                Toastify({
                    text: `${type} copied!`,
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

            } catch (err) {
                console.error('Failed to copy: ', err); // if error then console log error
            }
        }
    </script>

@endsection
