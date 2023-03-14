@extends('layout.master-dashboard')
@section('meta-title', 'Write Article - NightKite')
@section('meta-description', 'The page to write a new article or blog and then publish it to the website.')
@section('meta-og-title', "Create the Articles and Publish Them - NightKite")
@section('meta-og-description', "Publish the articles or blogs by also attaching the related tags and images too.")
@section('meta-canonical', url()->current())
@section('custom-css')
    <!-- summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('custom-content')
    <div class="m-2">

        <!-- title -->
        <h1 class="text-xl text-center mb-10"><i class="fa-solid fa-plus mr-1"></i> Create Article</h1>

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

                <!-- create article form -->
                <form action="{{ route('admin.dashboard.create-article') }}" method="POST" class="w-full"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- title -->
                    <div class="my-2">
                        <label for="article-title">Title</label>
                        <input type="text" placeholder="Title" class="input-form-sky" id="article-title"
                            name="title" />
                    </div>

                    <!-- meta_description -->
                    <div class="my-2">
                        <label for="article-meta-description">Short Descritption</label>
                        <input type="text" placeholder="Short Description" class="input-form-sky"
                            id="article-meta-description" name="meta_description">
                    </div>

                    <!-- description summernote -->
                    <div class="my-2">
                        <label for="summernote">Description</label>
                        <textarea id="summernote" name="description"></textarea>
                    </div>

                    <!-- tags -->
                    <div class="my-2">
                        <label for="tags">Tags</label>
                        <select multiple size="5"
                            class="block w-auto py-1 px-2 my-2 appearance-none border border-sky-400 focus:outline-none focus:ring focus:ring-sky-400"
                            name="tags[]" id="tags">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- image -->
                    <div class="my-2">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="input-file-type" />
                    </div>

                    <!-- create submit button -->
                    <button type="submit" class="green-button-rounded h-10 mt-5 whitespace-nowrap">
                        <i class="fa-solid fa-plus mr-1"></i> Create
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('custom-script')
    <!-- jquery script -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>

    <!-- summernote script -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        // initialize summernote
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
                ['view', ['help']]
            ]
        });
    </script>
@endsection
