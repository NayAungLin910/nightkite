@extends('layout.master-dashboard')
@section('meta-title', 'Create Tags - NightKite')
@section('meta-description',
    'The tags that can be tagged on the articles or blogs written in NightKite can be created
    on this page.')
@section('meta-og-title', "New tags Create Page - NightKite")
@section('meta-og-description', "New tags can be created and be attached to the related articles or blogs.")
@section('custom-content')
    <div class="m-2">
        <h1 class="text-xl text-center mb-10"><i class="fa-solid fa-plus mr-1"></i> Create Tags</h1>
        @if ($errors->any())
            <p class="text-md text-red-500 mb-1 text-center">
                Something went wrong!
            </p>
        @endif
        @foreach ($errors->all() as $error)
            <p class="text-sm my-1 text-red-500 text-center">
                {{ $error }}
            </p>
        @endforeach
        <form action="{{ route('admin.dashboard.create-tags') }}" method="POST">
            <div class="mb-4 place-content-center items-center px-4 flex gap-2">
                @csrf
                <div class="my-2">
                    <label for="tag-name">Name</label>
                    <input type="text" placeholder="Tag's name" class="input-form-sky md:w-80" id="tag-name"
                        name="name" />
                </div>
                <button type="submit" class="green-button-rounded h-10 mt-5 whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-1"></i> Create
                </button>
            </div>
        </form>
    </div>
@endsection
