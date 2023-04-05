@extends('layout.master-dashboard')
@section('meta-title', 'Update the Profile of ' . Auth::user()->name . ' - NightKite')
@section('meta-description', 'Update the user information of ' . Auth::user()->name)
@section('meta-og-title', Auth::user()->name . 'Update Profile Page - NightKite')
@section('meta-og-description', 'Update the profile of the Current User, ' . Auth::user()->name . ' from this page.')

@section('custom-content')

    <div class="m-2 md:mt-6 mt-16">
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
        <div class="mt-6 max-w-[25rem] mx-auto px-2">
            <form id="update-profile-accept-form" action="{{ route('admin.dashboard.update-profile') }}"
                enctype="multipart/form-data" method="POST">
                @csrf

                {{-- if errors --}}
                @if ($errors->any())
                    <div class="my-2">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- username -->
                <div class="my-2">
                    <label for="name-input"><i class="fa-solid fa-user"></i> Username</label>
                    <input id="name-input" type="text" name="name" class="input-form-sky"
                        value="{{ Auth::user()->name }}">
                </div>

                <!-- email -->
                <div class="my-2">
                    <label for="email-input"><i class="fa-solid fa-envelope"></i> Email</label>
                    <input id="email-input" type="email" name="email" class="input-form-sky"
                        value="{{ Auth::user()->email }}">
                </div>

                <!-- description -->
                <div class="my-2">
                    <label for="description-textarea"><i class="fa-solid fa-book"></i> Description</label>
                    <textarea name="description" id="description-textarea" cols="30" rows="10" class="input-form-sky h-44">{{ Auth::user()->description }}</textarea>
                </div>

                <!-- image -->
                <div class="my-2">
                    <label for="image">New Profile Image</label>
                    <input type="file" id="image" name="image" class="input-file-type" />
                </div>

                <!-- authentication password -->
                <div class="my-2">
                    <label for="password-auth-input"><i class="fa-solid fa-lock"></i> Password</label>
                    <input id="password-auth-input" name="password" class="input-form-sky" type="password">
                </div>

                <div class="mb-2 mt-4 flex items-center place-content-between">
                    <button type="button"
                        onclick="openPopupSubmit('Are you sure about updating the profile information of {{ Auth::user()->name }}?',
                        'update-profile')"
                        class="green-button-rounded"><i class="fa-solid fa-floppy-disk"></i>
                        Update</button>
                    <a href="{{ route('admin.dashboard.profile') }}" class="orange-button-rounded hover:no-underline"><i
                            class="fa-solid fa-arrow-left"></i>
                        Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-script')
    <script type="text/javascript" src="{{ asset('/js/popup.js') }}"></script>
@endsection
