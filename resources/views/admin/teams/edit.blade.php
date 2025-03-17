<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Add this for PUT method -->

                    <!-- Name Field -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            value="{{ old('name', $team->name) }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Occupation Field -->
                    <div class="mt-4">
                        <x-input-label for="occupation" :value="__('Occupation')" />
                        <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation"
                            value="{{ old('occupation', $team->occupation) }}" required autofocus autocomplete="occupation" />
                        <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                    </div>

                    <!-- Location Field -->
                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                            value="{{ old('location', $team->location) }}" required autofocus autocomplete="location" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Avatar Field -->
                    <div class="mt-4">
                        <x-input-label for="avatar" :value="__('Avatar')" />
                        <!-- Display existing avatar if it exists -->
                        @if ($team->avatar)
                            <img src="{{ asset('storage/' . $team->avatar) }}" alt="{{ $team->name }}"
                                class="rounded-2xl object-cover w-[90px] h-[90px] mb-2">
                        @endif
                        <x-text-input id="avatar" class="block mt-1 w-full" type="file" name="avatar" autofocus autocomplete="avatar" />
                        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded">
                            Update Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>