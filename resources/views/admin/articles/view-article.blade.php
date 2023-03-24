@extends('layout.master')
@section('meta-title', "$article->title - NightKite")
@section('meta-description', "$article->meta_description")
@section('meta-canonical', url()->current())
@section('custom-content')

    <!-- progress bar on scroll -->
    <div id="inner-progress-bar" class="sticky top-0 w-0 h-[0.3rem] rounded-tr-lg rounded-br-lg text-white bg-sky-500"></div>

    <div class="my-2">
        <div class="flex flex-col lg:flex-row gap-3">
            <div class="lg:w-[83%] px-3 text-justify">
                <!--top ads -->
                <div class="hidden md:block bg-slate-50 mx-auto w-[468px] h-[60px]"></div>
                <div class="w-[320px] h-[50px] bg-slate-50 my-2 mx-auto"></div>

                <!-- title -->
                <h1 class="text-2xl text-center font-semibold mt-2 mb-3">{{ $article->title }}</h1>

                <!-- article image -->
                <div class="px-3 pt-1 ">
                    <img src="{{ $article->image }}" class="rounded-lg max-h-[25rem] mx-auto" loading="lazy"
                        alt="{{ $article->title }}">
                </div>

                <!-- description -->
                <div id="article-description" class="mt-1 text-lg px-1">
                    {!! $article->description !!}
                </div>

                <!-- tags of the article -->
                <div class="mt-6 mb-4 flex flex-wrap gap-3 bg-slate-100 px-3 py-2 rounded-lg">
                    <p class="block w-full text-lg font-semibold">
                        Related Topics
                    </p>
                    @foreach ($article->tags as $tag)
                        <a class="px-3 hover:no-underline py-1 cursor-pointer rounded-md shadow-lg bg-sky-700 text-white">
                            {{ $tag->title }}
                        </a>
                    @endforeach
                </div>

                <!-- bottom ad -->
                <div class="w-[300px] h-[250px] bg-slate-50 my-2 mx-auto mt-2"></div>

                <!-- native banner -->
                <div class="w-full bg-slate-50 h-[150px]">Native banner</div>
            </div>
            <div class="lg:w-auto px-3 hidden fixed right-0 top-1/2 translate-y-[-50%] lg:block w-auto">
                <div class="w-[160px] h-[300px] bg-slate-50 my-2"></div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')

    <!-- js code pretiffier -->
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
    
    <!-- progressbar script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const progressInner = document.querySelector('#inner-progress-bar');

            window.addEventListener('scroll', function() {
                let rootElement = document.documentElement; // the root element of the document e.g.<html>
                let scrollTop = rootElement.scrollTop || document.body
                    .scrollTop; // pixels count scrolled from top
                let scrollHeight = rootElement.scrollHeight || document.body
                    .scrollHeight // height of the element

                let percentage = scrollTop / (scrollHeight - rootElement.clientHeight) *
                    100; // scroll percentage according to content

                let roundedPercent = Math.round(percentage); // rounded percentage number 

                progressInner.style.width = percentage + "%"; // expand width according to scroll percentage
            })
        })
    </script>
@endsection
