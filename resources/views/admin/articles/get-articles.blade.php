@extends('layout.master-dashboard')
@section('meta-title', 'Search Article - NightKite')
@section('meta-description', 'Search any article written on NightKite using various filter options given.')
@section('meta-canonical', url()->current())
@section('custom-content')
    <div class="my-2">

        <!-- title -->
        <h1 class="text-xl text-center mb-10"><i class="fa-solid fa-magnifying-glass mr-1"></i> Search Article</h1>

        <!-- filter options -->
        <div class="my-2 mx-2">
            <form action="{{ route('admin.dashboard.search-article') }}" id="clear-filter-form"></form>
            <form action="{{ route('admin.dashboard.search-article') }}">
                <div class="flex flex-col lg:flex-row items-center gap-4 mx-2 flex-wrap mb-3">
                    <div>
                        <label for="filter-search">Search</label>
                        <input value="{{ request('search') }}" type="text" class="input-form-sky" name="search"
                            id="filter-search" />
                    </div>
                    <div>
                        <label for="filter-timeline">Sort By</label>
                        <select name="timeline" class="select-sky" id="filter-timeline">
                            <option value="latest" @if (request('timeline') === 'latest') selected @endif>Latest</option>
                            <option value="oldest" @if (request('timeline') === 'oldest') selected @endif>Oldest</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter-tag">Tag</label>
                        <select name="tag" class="select-sky" id="filter-tag">
                            <option value="">None</option>
                            @foreach ($tags as $tag)
                                <option @if (request('tag') === strval($tag->id)) selected @endif value="{{ $tag->id }}">
                                    {{ $tag->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filter-by">By</label>
                        <select name="by" class="select-sky" id="filter-by">
                            <option value="all" @if (request('by') === 'all') selected @endif>All</option>
                            <option value="me" @if (request('by') === 'me') selected @endif>Me</option>
                            <option value="others" @if (request('by') === 'others') selected @endif>Others</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter-startdate">Start Date</label>
                        <input type="datetime-local" value="{{ request('startdate') }}" class="input-form-sky"
                            name="startdate" id="filter-startdate" />
                    </div>
                    <div>
                        <label for="filter-enddate">End Date</label>
                        <input type="datetime-local" value="{{ request('enddate') }}" class="input-form-sky" name="enddate"
                            id="filter-enddate" />
                    </div>
                    <button type="submit" class="green-button-rounded lg:mt-5">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                    <button type="submit" class="orange-button-rounded lg:mt-5" form="clear-filter-form">
                        <i class="fa-solid fa-broom"></i> Clear
                    </button>
                </div>
            </form>
        </div>

        <!-- articles display -->
        <div class="grid md:grid-cols-3 grid-cols-1 gap-1 gap-y-3">
            @foreach ($articles as $a)
                <div>
                    <div class="bg-slate-50 shadow-md mx-4 h-auto">
                        <img src="{{ $a->image }}" alt="{{ $a->title }}" class="rounded-t-xl mx-auto" width="auto"
                            height="auto" loading="lazy" />
                        <div class="py-2 px-4">
                            <p class="truncate"><a class="hover:underline text-blue-600 font-semibold mt-1"
                                    href="{{ url("/articles/$a->slug") }}">{{ $a->title }}</a></p>
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
