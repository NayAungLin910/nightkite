@extends('layout.master-dashboard')
@section('meta-title', 'Accept Accounts - NightKite')
@section('meta-description',
    'Accept the accounts that are registered in order to let the user login and publish blogs
    or articles. The accounts can also be declined on this page too.')
@section('meta-og-title', "Registered Admin Accounts Accept Page - NightKite")
@section('meta-og-description', "The admin accounts registered to NightKite can be accepted on this page.")
@section('custom-content')
    <div class="m-2">
        <h1 class="text-xl text-center"><i class="fa-solid fa-user-check mr-2"></i>Accept Accounts</h1>
        <div class="mt-10 mb-4">

            <!-- filtering options -->
            <form action="{{ route('admin.dashboard.accept-accounts') }}" id="clear-filter-form"></form>
            <form action="{{ route('admin.dashboard.accept-accounts') }}">
                <div class="flex flex-col lg:flex-row flex-wrap items-center gap-4 mx-2 mb-3">
                    <div>
                        <label for="filter-search">Search</label>
                        <input value="{{ request('search') }}" type="text" class="input-form-sky" name="search"
                            id="filter-search" />
                    </div>
                    <div>
                        <label for="filter-timeline">Sort By</label>
                        <select name="timeline"
                            class="my-2 px-2 w-full min-w-[4rem] whitespace-nowrap block h-8 text-black focus:outline-none border 
                        focus:ring focus:ring-sky-400 appearance-none border-sky-400 rounded-lg"
                            id="filter-timeline">
                            <option value="latest" @if (request('timeline') === 'latest') selected @endif>Latest</option>
                            <option value="oldest" @if (request('timeline') === 'oldest') selected @endif>Oldest</option>
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
                    <button type="submit" class="green-button-rounded lg:mt-5 whitespace-nowrap">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                    <button type="submit" class="orange-button-rounded lg:mt-5 whitespace-nowrap" form="clear-filter-form">
                        <i class="fa-solid fa-broom"></i> Clear
                    </button>
                </div>
            </form>

            <!-- if there are records -->
            @if ($admins->count() > 0)
                <div class="overflow-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse border">
                        <thead class="border-b text-lg">
                            <tr>
                                <th
                                    class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left text-transparent">
                                    Image
                                </th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Name</th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Email</th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Created At
                                </th>
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="border-b">
                            @foreach ($admins as $admin)
                                <tr class="border-b hover:bg-slate-50 group/admin">
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">
                                        <img class="max-h-14 rounded-full" src="{{ asset($admin->image) }}" loading="lazy"
                                            alt="{{ $admin->name }}'s profile image">
                                    </td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $admin->name }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $admin->email }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $admin->created_at }}
                                    </td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">
                                        <div class="flex items-center gap-2 opacity-0 group-hover/admin:opacity-100">

                                            <!-- accept account form -->
                                            <form action="{{ route('admin.dashboard.accept-accounts') }}"
                                                id="{{ $admin->email }}-accept-form" method="POST">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ $admin->email }}">
                                                <button type="button"
                                                    onclick='openPopupSubmit("Are you sure about accepting {{ $admin->email }} admin account?", "{{ $admin->email }}")'
                                                    class="green-button-rounded w-10">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>

                                            <!-- decline account form -->
                                            <form action="{{ route('admin.dashboard.decline-account') }}"
                                                id="{{ $admin->email }}-delete-form" method="POST">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ $admin->email }}">
                                                <button type="button"
                                                    onclick='openPopupDeleteSubmit("Are you sure about declining {{ $admin->email }} admin account?", "{{ $admin->email }}")'
                                                    class="orange-button-rounded w-10">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>

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
                {{ $admins->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script type="text/javascript" src="{{ asset('/js/popup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/popup-delete.js') }}"></script>
@endsection