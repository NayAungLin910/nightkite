@extends('layout.master')
@section('custom-content')
    <div class="px-3 py-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- main article -->
            @if ($mainArticle)
                <a href="{{ route('article.view', ['slug' => $mainArticle->slug]) }}" class="text-black hover:no-underline">
                    <div>
                        <img src="{{ url($mainArticle->image) }}" alt="Image of the arrticle, {{ $mainArticle->title }}"
                            class="max-h-[20rem] rounded-lg mx-auto" loading="lazy">
                        <div class="mt-2">
                            <h1 class="text-lg text-center font-semibold">{{ $mainArticle->title }}</h1>
                        </div>
                        <div class="my-2">
                            <p class="text-justify limit-lines-2">
                                {{ $mainArticle->meta_description }}
                            </p>
                        </div>
                    </div>
                </a>
            @else
                <div class="text-center mx-auto py-20">
                    <span class="text-lg font-semibold py-4 px-4 border bg-slate-50 shadow-md rounded-lg">
                        No featured article yet 😕!
                    </span>
                </div>
            @endif

            <!-- latest articles -->
            @if ($latestArticles && $latestArticles->count() > 0)
                <div>
                    <a href="{{ route('article.search') }}">
                        <h2 class="text-lg text-center font-semibold">Latest News</h2>
                    </a>
                    @foreach ($latestArticles as $la)
                        <a href="{{ route('article.view', ['slug' => $la->slug]) }}"
                            class="text-black hover:no-underline group/readmore">
                            <div
                                class="my-2 max-h-24 border shadow-md flex flex-row gap-3 rounded-xl items-center group-hover/readmore:bg-slate-50 group-hover/readmore:shadow-lg">
                                <img src="{{ url($la->image) }}" loading="lazy" class="max-h-24 rounded-tl-xl rounded-bl-xl"
                                    alt="Image of the article, '{{ $la->title }}'">

                                <p class="w-full font-semibold px-3 py-2 truncate">{{ $la->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center mx-auto py-20">
                    <span class="text-lg font-semibold py-4 px-4 border bg-slate-50 shadow-md rounded-lg">
                        No latest article yet 😕!
                    </span>
                </div>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- health & Fitness Articles -->
            @if ($healthArticles && $healthArticles->count() > 0)
                <div>
                    <a href="{{ route('article.search', ['tag' => $healthTag->id]) }}">
                        <h2 class="text-lg text-center font-semibold">Health & Fitness</h2>
                    </a>
                    @foreach ($healthArticles as $ha)
                        <a href="{{ route('article.view', ['slug' => $ha->slug]) }}"
                            class="text-black hover:no-underline group/readmore">
                            <div
                                class="my-2 max-h-24 border shadow-md flex flex-row gap-3 rounded-xl items-center group-hover/readmore:bg-slate-50 group-hover/readmore:shadow-lg">
                                <img src="{{ url($ha->image) }}" loading="lazy"
                                    class="max-h-24 rounded-tl-xl rounded-bl-xl"
                                    alt="Image of the article, '{{ $ha->title }}'">

                                <p class="w-full font-semibold px-3 py-2 truncate">{{ $ha->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center mx-auto py-20">
                    <span class="text-lg font-semibold py-4 px-4 border bg-slate-50 shadow-md rounded-lg">
                        No Health & Fitness article yet 😕!
                    </span>
                </div>
            @endif

            <!-- coding Articles -->
            @if ($codingArticles && $codingArticles->count() > 0)
                <div>
                    <a href="{{ route('article.search', ['tag' => $codingTag->id]) }}">
                        <h2 class="text-lg text-center font-semibold">Coding</h2>
                    </a>
                    @foreach ($codingArticles as $ca)
                        <a href="{{ route('article.view', ['slug' => $ca->slug]) }}"
                            class="text-black hover:no-underline group/readmore">
                            <div
                                class="my-2 max-h-24 border shadow-md flex flex-row gap-3 rounded-xl items-center group-hover/readmore:bg-slate-50 group-hover/readmore:shadow-lg">
                                <img src="{{ url($ca->image) }}" loading="lazy"
                                    class="max-h-24 rounded-tl-xl rounded-bl-xl"
                                    alt="Image of the article, '{{ $ca->title }}'">

                                <p class="w-full font-semibold px-3 py-2 truncate">{{ $ca->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center mx-auto py-20">
                    <span class="text-lg font-semibold py-4 px-4 border bg-slate-50 shadow-md rounded-lg">
                        No coding articles yet 😕!
                    </span>
                </div>
            @endif

            <div>

            </div>
        </div>
    </div>
@endsection
