<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Teams') }}
            </h2>
            <a href="{{ route('admin.teams.create') }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded">
                Add New
            </a>
        </div>
    </x-slot>
    {{-- Notifikasi SweetAlert --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#4F46E5",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6">

                <!-- SEARCH BAR -->
                <div class="px-1 py-3">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <form action="{{ route('admin.teams.index') }}" method="GET" class="flex items-center">
                            <input type="text" id="table-search" name="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search by name, occupation, location" value="{{ request('search') }}">
                            <button type="submit"
                                class="ml-2 p-2.5 text-sm font-medium text-white bg-white-700 rounded-lg border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>
                    </div>
                    <div class="relative mt-1">
                        <form action="{{ route('admin.teams.index') }}" method="GET">                    
                            <select name="occupation" class="py-2 px-8 bg-white-500 text-gray-500 rounded">
                                <option value="">All Occupations</option>
                                @foreach ($occupations as $ocp)
                                    <option value="{{ $ocp }}" {{ request('occupation') == $ocp ? 'selected' : '' }}>{{ $ocp }}</option>
                                @endforeach
                            </select>
        
                            <select name="location"  class="py-2 px-8 bg-white-500 text-gray-500 rounded">
                                <option value="">All Locations</option>
                                @foreach ($locations as $loc)
                                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
        
                            <button class="font-bold ms-2 py-2 px-4 bg-indigo-700 text-white rounded" type="submit">Filter</button>
                        </form>
                    </div>
                </div>


                <!--MAIN TABLE -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Avatar</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Occupation</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($teams as $team)
                            <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{$loop->iteration}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ Storage::url($team->avatar) }}" 
                                         alt="Team Avatar" 
                                         class="rounded-2xl object-cover w-[50px] h-[50px]">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $team->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">{{ $team->occupation }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">{{ $team->location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                     <a href="{{ route('admin.teams.edit', $team) }}" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                        Edit
                                    </a>
                                    <button onclick="confirmDelete('{{ $team->id }}')" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                        Delete
                                    </button>
                                    <form id="deleteForm-{{ $team->id }}" action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-800">Are you sure?</h3>
            <p class="text-sm text-gray-600">This action cannot be undone.</p>
            <div class="flex justify-end mt-4 gap-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">
                    Cancel
                </button>
                <button id="confirmDeleteButton" class="px-4 py-2 bg-red-600 text-white rounded-lg">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- SweetAlert for Delete Confirmation --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
