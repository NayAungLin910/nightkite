@extends('layout.master-dashboard')
@section('meta-title', 'Search Article - NightKite')
@section('meta-description', 'Search any article written on NightKite using various filter options given.')
@section('meta-canonical', url()->current())
@section('custom-content')
    <div class="my-2">

        <!-- title -->
        <h1 class="text-xl text-center mb-10"><i class="fa-solid fa-magnifying-glass mr-1"></i> Search Article</h1>

        <!-- articles display -->
        <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-1 gap-y-3">
            @foreach ($articles as $a)
                <div>
                    <div class="bg-slate-50 shadow-md mx-4 h-auto">
                        <img src="{{ $a->image }}" alt="{{ $a->title }}" class="rounded-t-xl mx-auto" width="auto" height="auto" loading="lazy" />
                        <div class="py-2 px-4">
                            <p class="truncate"><a class="hover:underline text-blue-400 font-semibold mt-1"
                                    href="">{{ $a->title }}</a></p>
                            <p class="text-justify text-sm mt-1 limit-lines">
                                {{ $a->meta_description }}
                            </p>
                            <p class="truncate text-xs opacity-70 mt-1">Created On: {{ $a->created_at }}</p>
                            <p class="truncate text-xs opacity-70">Updated On: {{ $a->updated_at }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- pagination -->
        <div class="mx-4 my-2">
            {{ $articles->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
