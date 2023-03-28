@extends('layout.master')
@section('custom-content')
    <div class="px-3 py-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @if ($mainArticle)
                <a href="{{ route('article.view', ["slug" => $mainArticle->slug]) }}"
                    class="text-black hover:no-underline">
                    <div>
                        <img src="{{ url($mainArticle->image) }}" alt="Image of the arrticle, {{ $mainArticle->title }}"
                            class="max-h-[20rem] rounded-lg mx-auto" loading="lazy">
                        <div class="mt-2">
                            <h1 class="text-lg text-center font-semibold">{{ $mainArticle->title }}</h1>
                        </div>
                        <div>
                            <p class="text-justify limit-lines-2">
                                {{ $mainArticle->meta_description }}
                            </p>
                        </div>
                    </div>
                </a>
            @endif
            <div>Categorized article</div>
        </div>
    </div>
@endsection
