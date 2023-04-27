@extends('layout.master')

@section('meta-title', "The Author, $author->name's Introduction Page - NightKite")
@section('meta-description',
    "The page where the author, $author->name's articles and the additional information are
    shown")

@section('meta-og-title', "$author->name Introudction Page - NightKite")
@section('meta-og-description',
    "Check out the articles written by $author->name, which are very valuable and
    informative.")

@section('custom-content')
    <div class="px-3 py-2">

        <!-- author info -->
        <div class="my-3">
            <img src="{{ url($author->image) }}" class="max-h-24 rounded-full border shadow mx-auto" loading="lazy"
                alt="{{ $author->name }}'s profile image" />
            <h1 class="text-xl font-semibold text-center mt-2">{{ $author->name }}</h1>
            <h2 class="text-lg text-center">{{ $author->email }}</h2>
            <p class="text-lg my-3 text-center md:w-1/2 mx-auto">
                {{ $author->description }}
            </p>
        </div>
    </div>

    @if ($articles && $articles->count() > 0)
        <!-- articles of the author -->
        <div class="bg-slate-100 px-3 py-2">
            <h2 class="text-lg ml-3 my-3">Some of the works of <span class="font-semibold">{{ $author->name }}</span></h2>

            <div class="grid md:grid-cols-3 grid-cols-1 gap-1 gap-y-3">
                @foreach ($articles as $article)
                    <div class="bg-slate-50 shadow-lg rounded-t-xl mx-2 my-1 h-auto hover:shadow-2xl">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}"
                            class="rounded-t-xl mx-auto max-h-[25rem]" loading="lazy" />
                        <div class="py-2 px-4">
                            <p class="truncate"><a class="hover:underline text-blue-600 font-semibold mt-1"
                                    href="{{ url("/articles/$article->slug") }}">{{ $article->title }}</a></p>
                            <p class="text-justify text-sm mt-1 limit-lines">
                                {{ $article->meta_description }}
                            </p>
                            <p class="truncate text-xs opacity-70 mt-1">Created On: {{ $article->created_at }}</p>
                            <p class="truncate text-xs opacity-70">Updated On: {{ $article->updated_at }}</p>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- pagination -->
            <div class="mx-4 my-2">
                {{ $articles->withQueryString()->links('pagination::tailwind') }}
            </div>

        </div>
    @else
        <div class="my-2 mx-auto text-center py-20">
            <span class="text-lg font-semibold py-4 px-4 bg-slate-100 shadow-md rounded-lg">No articles found
                😕!</span>
        </div>
    @endif

@endsection
