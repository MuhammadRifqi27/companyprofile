<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Statistics') }}
            </h2>
            <a href="{{ route('admin.statistics.create') }}" 
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
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Icon</th>
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Statistic Name</th>
                                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Date</th>
                                        <th class="px-6 py-3 text-end text-xs font-medium text-gray-600 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($statistics as $statistic)
                                        <tr class="hover:bg-gray-50 transition">
                                            <!-- Icon -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <img src="{{ Storage::url($statistic->icon) }}" 
                                                    alt="Statistic Icon" 
                                                    class="rounded-2xl object-cover w-[50px] h-[50px] shadow-xl">
                                            </td>
                                            
                                            <!-- Name -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{ $statistic->name }}
                                            </td>

                                            <!-- Date -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ \Carbon\Carbon::parse($statistic->created_at)->format('d F Y') }}
                                            </td>

                                            <!-- Action Buttons -->
                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <a href="{{ route('admin.statistics.edit', $statistic) }}" 
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                                    Edit
                                                </a>
                                                <form id="deleteForm-{{ $statistic->id }}" 
                                                    action="{{ route('admin.statistics.destroy', $statistic) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('{{ $statistic->id }}')" 
                                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center px-6 py-4 text-gray-600">
                                                No statistics available.
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
