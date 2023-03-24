@extends('layout.master-dashboard')
@section('meta-title', "$article->title - NightKite")
@section('meta-description', "$article->meta_description")
@section('meta-og-title', "Read an article about $article->title")
@section('meta-og-description',
    "Read the description of $article->title, which is as follows,
    $article->meta_description - NightKite")
@section('meta-canonical', url()->current())
@section('custom-css')
    <!-- summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('custom-content')
    <div class="m-2">

        <!-- title -->
        <h1 class="text-xl text-center mb-10"><i class="fa-solid fa-floppy-disk mr-1"></i> Edit - {{ $article->title }}</h1>

        <!-- error display -->
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

        <div class="flex item-center">
            <div class="md:w-[80%] w-full mx-4 md:mx-auto">

                <!-- edit article form -->
                <form action="{{ route('admin.dashboard.edit-article', ['slug' => $article->slug]) }}" method="POST"
                    class="w-full" enctype="multipart/form-data">
                    @csrf

                    <!-- title -->
                    <div class="my-2">
                        <label for="article-title">Title</label>
                        <input type="text" value="{{ $article->title }}" placeholder="Title" class="input-form-sky"
                            id="article-title" name="title" />
                    </div>

                    <!-- meta_description -->
                    <div class="my-2">
                        <label for="article-meta-description">Short Descritption</label>
                        <input value="{{ $article->meta_description }}" type="text" placeholder="Short Description"
                            class="input-form-sky" id="article-meta-description" name="meta_description">
                    </div>

                    <!-- description summernote -->
                    <div class="my-2">
                        <label for="summernote">Description</label>
                        <textarea id="summernote" name="description">
                        </textarea>
                    </div>

                    <!-- tags -->
                    <div class="my-2">
                        <label for="tags">Tags</label>
                        <select multiple size="5"
                            class="block w-auto py-1 px-2 my-2 appearance-none border border-sky-400 focus:outline-none focus:ring focus:ring-sky-400"
                            name="tags[]" id="tags">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    @foreach ($tag->articles as $a)
                                        @if ($a->slug === $article->slug)
                                            selected
                                        @endif @endforeach>
                                    {{ $tag->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- image -->
                    <div class="my-2">
                        <label for="image">Add New Main Image</label>
                        <input type="file" name="image" class="input-file-type" />
                    </div>

                    <!-- create submit button -->
                    <button type="submit" class="green-button-rounded h-10 mt-5 whitespace-nowrap">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('custom-script')
    <!-- js code pretiffier -->
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>


    <!-- jquery script -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>

    <!-- summernote script -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>

        $('#summernote').summernote({
            placeholder: 'Description',
            minHeight: '15rem',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['help']],
            ],
        });
        $('#summernote').summernote("code", `{!! $article->description !!}`)
    </script>
@endsection
