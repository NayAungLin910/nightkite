@section('meta-title', 'Login - NightKite')
@section('meta-description', 'The admin login page of NightKite article website. If your account is already registered, login to publish articles and manage them.')
@section('meta-canonical', url()->current())
@section('meta-og-title', 'NightKite Admin Login Page')
@section('meta-og-description', 'The page to login to the NightKite article website for pubslishing the articles and editing them.')
@section('meta-og-url', url()->current())

@extends('layout.master')
@section('custom-content')
    <div class="">
        <div class="mx-auto my-4 rounded-xl shadow-md px-6 py-3 lg:w-1/3">
            <h1 class="text-2xl text-center">Login - NightKite</h1>
            <form action="{{ route('admin.login') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                    <label for="email">Email</label>
                    <input id="email" name="email" placeholder="Email..." class="input-form-sky" type="email" />
                </div>
                <div class="my-2">
                    <label for="password">Password</label>
                    <input id="password" name="password" placeholder="********" class="input-form-sky" type="password" />
                </div>
                <div class="my-2">
                    <a class="text-sm underline text-sky-500" href="{{ route('admin.register') }}">Reigster an account</a>
                </div>
                <div class="my-2">
                    <label for="remember">Remember Me</label>
                    <input id="remember" name="remember" checked class=" my-2 py-2 px-4 rounded-lg w-5 block h-5"
                        type="checkbox" />
                </div>
                <button class="flex items-center gap-1 sky-button-rounded mt-5">
                    <i class="fa-solid fa-check text-sm"></i>
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection
