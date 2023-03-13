@extends('layout.master-dashboard')
@section('meta-title', "Rename the tag, $tag->title - NightKite")
@section('meta-description',
    "The tag, $tag->title can be renamed on this page.")
@section('meta-og-title', "$tag->title, rename page - NightKite")
@section('meta-og-description', "$tag->title, tag can be easily renamed by just submitting the form on the page. - NightKite")
@section('custom-content')
    <div class="mx-2 mt-2">
        <h1 class="text-xl text-center mt-[4rem] lg:mt-0 mb-10"><i class="fa-solid fa-pen-to-square mr-1"></i> Rename the tag, {{ $tag->title }}</h1>
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
        <form action="{{ route('admin.dashboard.update-tag', ['slug' => $tag->slug]) }}" method="POST">
            <div class="mb-4 place-content-center items-center px-4 flex gap-2">
                @csrf
                <div class="my-2">
                    <label for="tag-name">Name</label>
                    <input type="text" value="{{ $tag->title }}" placeholder="Tag's name" class="input-form-sky md:w-80" id="tag-name"
                        name="name" />
                </div>
                <button type="submit" class="green-button-rounded h-10 mt-5 whitespace-nowrap">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Save
                </button>
            </div>
        </form>
    </div>
@endsection
