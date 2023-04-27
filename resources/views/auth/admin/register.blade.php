@extends('layout.master')

@section('meta-title', 'Register - NightKite')
@section('meta-description',
    'The admin account registration page of the NightKite article website. Register an account
    to publish articles and manage them.')

@section('meta-og-title', 'NightKite Admin Register Page')
@section('meta-og-description', 'The page to register an admin account to the NightKite article website for publishing
    the articles and editing them.')

@section('custom-content')
    <div class="">
        <div class="mx-auto my-4 rounded-xl shadow-md border bg-slate-50 px-6 py-3 lg:w-1/3">
            <h1 class="text-2xl text-center">Register - NightKite</h1>
            <form action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="my-2">
                    <p class="text-sm p-2 rounded-lg bg-slate-50">
                        Note: After successfully registering your account. You will have to wait for
                        the super admin to accept the account in order to log in from that account.
                    </p>
                </div>
                @if ($errors->any())
                    <p class="text-md text-red-500 mb-2">
                        Something went wrong!
                    </p>
                @endif
                @foreach ($errors->all() as $error)
                    <p class="text-sm my-1 text-red-500">
                        {{ $error }}
                    </p>
                @endforeach
                <div class="my-2">
                    <label for="name">Name</label>
                    <input id="name" name="name" placeholder="Name..." class="input-form-sky" type="text" />
                </div>
                <div class="my-2">
                    <label for="email">Email</label>
                    <input id="email" name="email" placeholder="Email..." class="input-form-sky" type="email" />
                </div>
                <div class="my-2">
                    <label for="password">Password</label>
                    <input id="password" name="password" placeholder="********" class="input-form-sky" type="password" />
                </div>
                <div class="my-2">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" placeholder="********"
                        class="input-form-sky" type="password" />
                </div>
                <div class="my-2">
                    <label for="description">Short Description</label>
                    <textarea name="description" class="input-form-sky h-44" id="description" cols="30" rows="10"
                        placeholder="Short Description..."></textarea>
                </div>
                <div class="my-2">
                    <label for="image">Image</label>
                    <input id="image" name="image" class="input-file-type" type="file" />
                </div>
                <div class="my-2">
                    <a class="text-sm underline text-sky-500" href="{{ route('admin.login') }}">Login from an account</a>
                </div>
                <div class="my-2">
                    <label for="remember">Remember Me</label>
                    <input id="remember" name="remember" checked class=" my-2 py-2 px-4 rounded-lg w-5 block h-5"
                        type="checkbox" />
                </div>
                <button class="flex items-center gap-1 sky-button-rounded mt-5">
                    <i class="fa-solid fa-check text-sm"></i>
                    Register
                </button>
            </form>
        </div>
    </div>
@endsection
