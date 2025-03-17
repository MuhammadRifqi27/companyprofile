<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                {{ __('Manage Hero Sections') }}
            </h2>
            <a href="{{ route('admin.hero_sections.create') }}" 
               class="font-bold py-2 px-4 bg-indigo-700 text-white rounded hover:bg-indigo-800 transition">
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
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="px-6 py-3 text-start text-xs font-medium uppercase">Image</th>
                                <th class="px-6 py-3 text-start text-xs font-medium uppercase">Heading</th>
                                <th class="px-6 py-3 text-start text-xs font-medium uppercase">Sub Heading</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase">Achievement</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase">Path Video</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase">Date</th>
                                <th class="px-6 py-3 text-end text-xs font-medium uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($hero_sections as $hero_section)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Image -->
                                <td class="px-6 py-4">
                                    <img src="{{ Storage::url($hero_section->banner) }}" 
                                         alt="Hero Image" 
                                         class="rounded-lg object-cover w-[80px] h-[80px] border-2 border-indigo-600 shadow-md">
                                </td>

                                <!-- Heading -->
                                <td class="px-6 py-4 text-gray-800 text-md font-semibold">
                                    {{ $hero_section->heading }}
                                </td>
                                <td class="px-6 py-4 text-gray-800 text-md font-semibold">
                                    {{ $hero_section->subheading }}
                                </td>

                                <!-- Achievement -->
                                <td class="px-6 py-4 text-center text-gray-800 text-md">
                                    {{ $hero_section->achievement }}
                                </td>
                                
                                <td class="px-6 py-4 text-center text-gray-800 text-md">
                                    <button onclick="window.open('{{ $hero_section->path_video }}', '_blank')" 
                                            class="inline-flex items-center px-2 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-900 transition-colors duration-400">
                                        Link Video
                                    </button>
                                </td>
                                <!-- Date -->
                                <td class="px-6 py-4 text-center text-gray-800 text-md">
                                    {{ \Carbon\Carbon::parse($hero_section->created_at)->format('d F Y') }}
                                </td>
                                
                                <!-- Action Buttons -->
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <a href="{{ route('admin.hero_sections.edit', $hero_section) }}" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                        Edit
                                    </a>
                                    <form id="deleteForm-{{ $hero_section->id }}" action="{{ route('admin.hero_sections.destroy', $hero_section) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $hero_section->id }}')" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hero sections available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
