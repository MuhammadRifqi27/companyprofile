<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Testimonials') }}
            </h2>
            <a href="{{ route('admin.testimonials.create') }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded">
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
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Thumbnail</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Message</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($testimonials as $testimonial)
                            <tr>
                                <!-- Thumbnail -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ Storage::url($testimonial->thumbnail) }}" 
                                         alt="Testimonial Thumbnail" 
                                         class="rounded-2xl object-cover w-[60px] h-[60px]">
                                </td>

                                <!-- Message -->
                                <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-800 max-w-[500px]">
                                    {{ $testimonial->message }}
                                </td>


                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($testimonial->created_at)->format('M d, Y') }}
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium ">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-yellow-600 hover:text-yellow-800 bg-yellow-100 rounded-lg">
                                        Edit
                                    </a>
                                    <form id="deleteForm-{{ $testimonial->id }}" action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $testimonial->id }}')" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 hover:text-red-800 bg-red-100 rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data terbaru</td>
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
