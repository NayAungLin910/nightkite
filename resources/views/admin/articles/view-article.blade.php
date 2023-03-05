@extends('layout.master')
@section('meta-title',  "$article->title- NightKite")
@section('meta-description', "$article->meta_description")
@section('meta-canonical', url()->current())
@section('custom-content')
    <div class="my-2">

        <!-- title -->
        <h1 class="text-xl text-center mb-3">{{ $article->title }}</h1>

        <!-- description -->
        <div>
            {!! $article->description !!}
        </div>
    </div>
@endsection
