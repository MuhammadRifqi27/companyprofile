<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Principles') }}
            </h2>
            <a href="{{ route('admin.principles.create') }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded">
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
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Icon</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Principle</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($principles as $principle)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ Storage::url($principle->icon) }}" 
                                         alt="Principle Icon" 
                                         class="rounded-2xl object-cover w-[50px] h-[50px]">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $principle->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">{{ $principle->subtitle }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($principle->created_at)->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <a href="{{ route('admin.principles.edit', $principle) }}" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                        Edit
                                    </a>
                                    <button onclick="confirmDelete('{{ $principle->id }}')" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                        Delete
                                    </button>
                                    <form id="deleteForm-{{ $principle->id }}" action="{{ route('admin.principles.destroy', $principle) }}" method="POST" class="hidden">
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
