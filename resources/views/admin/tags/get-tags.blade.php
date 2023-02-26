@extends('layout.master-dashboard')
@section('meta-title', 'Search Tags - NightKite')
@section('meta-description',
    'Search the tags that are tagged along with blogs and articles using various filter
    options.')
@section('custom-content')
    <div class="m-2">
        <h1 class="text-xl text-center"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search Tags</h1>
        <div class="mt-10 mb-4">

            <!-- filtering options -->
            <form action="{{ route('admin.dashboard.get-tags') }}" id="clear-filter-form"></form>
            <form action="{{ route('admin.dashboard.get-tags') }}">
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
                        <label for="filter-by">By</label>
                        <select name="by" class="select-sky" id="filter-by">
                            <option value="all" @if (request('by') === 'all') selected @endif>All</option>
                            <option value="me" @if (request('by') === 'me') selected @endif>Me</option>
                            <option value="others" @if (request('by') === 'others') selected @endif>Others</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter-startdate">Start Date</label>
                        <input type="datetime-local" value="{{ request('startdate') }}" class="input-form-sky" name="startdate"
                            id="filter-startdate" />
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

            <!-- if there are records -->
            @if ($tags->count() > 0)
                <div class="overflow-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse border">
                        <thead class="border-b text-lg">
                            <tr>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Title</th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Admin</th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Created At
                                </th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Articles
                                    Count
                                </th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="border-b">
                            @foreach ($tags as $tag)
                                <tr class="border-b hover:bg-slate-50 group/tag">
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $tag->title }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">

                                        <!-- if user exists, show user name if not show not found! -->
                                        @if ($tag->user)
                                            {{ $tag->user->name }}
                                        @else
                                            <p
                                                class=" w-[5.5rem] whitespace-nowrap bg-slate-200 rounded-lg px-2 py-1 italic">
                                                Not found!
                                            </p>
                                        @endif

                                    </td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $tag->created_at }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $tag->articles_count }}
                                    </td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">
                                        <div
                                            class="flex items-center gap-2 {{ Auth::user()->role === '3' ? 'opacity-0 group-hover/tag:opacity-100' : '' }} ">

                                            <!-- if the current user is super admin or the admin who created the tag, then display delete button -->
                                            @if (Auth::user()->role === '3' || Auth::user()->id === $tag->user_id)
                                                <!-- delete tag form -->
                                                <form action="{{ route('admin.dashboard.delete-tag') }}"
                                                    id="{{ $tag->slug }}-delete-form" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="slug" value="{{ $tag->slug }}">
                                                    <button type="button"
                                                        onclick='openPopupSubmit("Are you sure about deleting {{ $tag->title }} tag?", "{{ $tag->slug }}", "delete")'
                                                        class="orange-button-rounded w-10">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- else show fake button -->
                                                <button type="button" disabled
                                                    class="orange-button-rounded w-10 opacity-0">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- if no record -->
                <div class="text-center py-20">
                    <span class="text-lg font-semibold py-4 px-4 bg-slate-50 shadow-md rounded-lg">No records found
                        😕!</span>
                </div>
            @endif

            <!-- pagination -->
            <div class="mx-4 my-2">
                {{ $tags->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
