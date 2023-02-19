@extends('layout.master-dashboard')
@section('custom-content')
    <div class="m-2">
        <h1 class="text-xl text-center"><i class="fa-solid fa-user-check mr-2"></i>Accept Accounts</h1>
        <div class="my-4">
            <div class="overflow-auto rounded-lg shadow-md">
                <table class="w-full border-collapse border">
                    <thead class="border-b text-lg">
                        <tr>
                            <th class="p-3 w-auto tracking-wide font-semibold whitespace-nowrap text-left">Image</th>
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
                                <td class="py-1 px-2 w-auto font-normal whitespace-nowrap"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mx-4 my-2">
                {{ $admins->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
