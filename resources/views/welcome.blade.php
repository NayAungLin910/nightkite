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
                        <h2 class="text-lg text-center font-semibold">Latest Articles</h2>
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

            <!-- Featured Articles -->
            @if ($featuredTags && $featuredTags->count() > 0)
                @foreach ($featuredTags as $featuredTag)
                    <div>
                        <a href="{{ route('article.search', ['tag' => $featuredTag->id]) }}">
                            <h2 class="text-lg text-center font-semibold">{{ $featuredTag->title }}</h2>
                        </a>
                        @if ($featuredTag->articles && $featuredTag->articles->count() > 0)
                            @foreach ($featuredTag->articles->take(4) as $ftArticle)
                                <a href="{{ route('article.view', ['slug' => $ftArticle->slug]) }}"
                                    class="text-black hover:no-underline group/readmore">
                                    <div
                                        class="my-2 max-h-24 border shadow-md flex flex-row gap-3 rounded-xl items-center group-hover/readmore:bg-slate-50 group-hover/readmore:shadow-lg">
                                        <img src="{{ url($ftArticle->image) }}" loading="lazy"
                                            class="max-h-24 rounded-tl-xl rounded-bl-xl"
                                            alt="Image of the article, '{{ $ftArticle->title }}'">

                                        <p class="w-full font-semibold px-3 py-2 truncate">{{ $ftArticle->title }}</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center mx-auto py-6">
                                <span class="text-lg font-semibold p-4 border bg-slate-50 shadow-md rounded-lg">
                                    No articles related with the tag, {{ $featuredTag->title }} 😕!
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center mx-auto py-20">
                    <span class="text-lg font-semibold py-4 px-4 border bg-slate-50 shadow-md rounded-lg">
                        No featured tags yet 😕!
                    </span>
                </div>
            @endif
        </div>
    </div>
@endsection
