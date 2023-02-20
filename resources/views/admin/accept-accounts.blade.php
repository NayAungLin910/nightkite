@extends('layout.master-dashboard')
@section('custom-content')
    <div class="m-2">
        <h1 class="text-xl text-center"><i class="fa-solid fa-user-check mr-2"></i>Accept Accounts</h1>
        <div class="mt-10 mb-4">

            <!-- filtering options -->
            <form action="{{ route('admin.dashboard.accept-accounts') }}" id="clear-filter-form"></form>
            <form action="{{ route('admin.dashboard.accept-accounts') }}">
                <div class="flex flex-col lg:flex-row items-center gap-4 mx-2">
                    <div>
                        <label for="filter-search">Search</label>
                        <input value="{{ $search }}" type="text" class="input-form-sky" name="search"
                            id="filter-search" />
                    </div>
                    <div>
                        <label for="filter-startdate">Start Date</label>
                        <input type="datetime-local" value="{{ $reqStartDate }}" class="input-form-sky" name="startdate"
                            id="filter-startdate" />
                    </div>
                    <div>
                        <label for="filter-enddate">End Date</label>
                        <input type="datetime-local" value="{{ $reqEndDate }}" class="input-form-sky" name="enddate"
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
                                <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="border-b">
                            @foreach ($admins as $admin)
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">
                                        <img class="max-h-14 rounded-full" src="{{ asset($admin->image) }}" loading="lazy"
                                            alt="{{ $admin->name }}'s profile image">
                                    </td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $admin->name }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">{{ $admin->email }}</td>
                                    <td class="py-1 px-2 w-auto font-normal whitespace-nowrap">
                                        <div class="flex items-center gap-2">

                                            <!-- accept account form -->
                                            <form action="{{ route('admin.dashboard.accept-accounts') }}"
                                                id="{{ $admin->email }}-accept-form" method="POST">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ $admin->email }}">
                                                <button type="button"
                                                    onclick='openPopupSubmit("Are you sure about accepting {{ $admin->email }} admin account?", "{{ $admin->email }}", "submit")'
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
                                                    onclick='openPopupSubmit("Are you sure about declining {{ $admin->email }} admin account?", "{{ $admin->email }}", "delete")'
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
