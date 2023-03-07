@extends('layout.master')
@section('meta-title', "$article->title - NightKite")
@section('meta-description', "$article->meta_description")
@section('meta-canonical', url()->current())
@section('custom-content')
    <div class="my-2">
        <div class="flex flex-col lg:flex-row gap-3">
            <div class="lg:w-[83%] px-3 text-justify">
                <!--top ads -->
                <div class="hidden md:block bg-slate-50 mx-auto w-[468px] h-[60px]"></div>
                <div class="w-[320px] h-[50px] bg-slate-50 my-2 mx-auto"></div>

                <!-- title -->
                <h1 class="text-xl text-center mb-3">{{ $article->title }}</h1>

                <!-- article image -->
                <div class="px-3 pt-1 ">
                    <img src="{{ $article->image }}" class="rounded-lg max-h-[25rem] mx-auto" loading="lazy"
                        alt="{{ $article->title }}">
                </div>

                <!-- description -->
                <div id="article-description" class="mt-1">
                    {!! $article->description !!}
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
