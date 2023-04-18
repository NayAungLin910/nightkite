@extends('layout.master-dashboard')

@section('meta-title', 'Change the Password of ' . Auth::user()->name . ' - NightKite')
@section('meta-description', 'Change the current password of ' . Auth::user()->name)

@section('meta-og-title', Auth::user()->name . ', Change Password Page - NightKite')
@section('meta-og-description', 'Change the password of the current user, ' . Auth::user()->name . ' from NightKite.')

@section('custom-content')
    <div class="m-2 md:mt-6 mt-16">
        <h1 class="text-xl text-center">
            <img src="{{ Auth::user()->image }}" loading="lazy" alt="{{ Auth::user()->name }}'s profile image"
                class="rounded-full border mb-2 shadow mx-auto max-h-[8rem]">
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
        <div class="mt-6 max-w-[25rem] mx-auto px-2">
            <form id="change-password-accept-form" action="{{ route('admin.dashboard.change-password') }}" method="POST">
                @csrf

                {{-- if errors --}}
                @if ($errors->any())
                    <div class="my-2">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- new password -->
                <div class="my-2">
                    <label for="password-new-input">New Password</label>
                    <input id="password-new-input" name="new_password" class="input-form-sky" type="password">
                </div>

                <!-- confirm password -->
                <div class="my-2">
                    <label for="password-confirm-input">Confirm New Password</label>
                    <input id="password-confirm-input" name="new_password_confirmation" class="input-form-sky"
                        type="password">
                </div>

                <!-- authentication password -->
                <div class="my-2">
                    <label for="password-auth-input">Old Password</label>
                    <input id="password-auth-input" name="password" class="input-form-sky" type="password">
                </div>

                <div class="mb-2 mt-4 flex items-center place-content-between">
                    <button type="button"
                        onclick="openPopupSubmit('Are you sure about changing the new password?',
                        'change-password')"
                        class="green-button-rounded"><i class="fa-solid fa-repeat"></i>
                        Change</button>
                    <a href="{{ route('admin.dashboard.profile') }}" class="orange-button-rounded hover:no-underline"><i
                            class="fa-solid fa-arrow-left"></i>
                        Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-script')
    @include('partials.popup')
@endsection
