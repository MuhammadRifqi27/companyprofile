<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage About') }}
            </h2>
            <a href="{{ route('admin.abouts.create') }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded">
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

    {{-- Floating Card --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Thumbnail</th>
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Name</th>
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Type</th>
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Date</th>
                                        <th class="px-6 py-3 text-end text-xs font-medium text-gray-600 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($abouts as $about)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <img src="{{ Storage::url($about->thumbnail) }}" 
                                                    alt="Thumbnail" class="rounded-lg object-cover w-[50px] h-[50px] shadow-md">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $about->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $about->type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ \Carbon\Carbon::parse($about->created_at)->format('d F Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <a href="{{ route('admin.abouts.edit', $about) }}" 
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                                    Edit
                                                </a>
                                                <form id="deleteForm-{{ $about->id }}" 
                                                    action="{{ route('admin.abouts.destroy', $about) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('{{ $about->id }}')" 
                                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center px-6 py-4 text-gray-600">
                                                Belum ada data terbaru
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> {{-- End of Floating Card --}}
        </div>
    </div>

    {{-- Script SweetAlert untuk konfirmasi hapus --}}
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
