<x-app-layout>
    <x-slot name="header">
        Create a new team
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-md">
        <form class="form-horizontal" method="post" action="{{route('teams.store')}}">
            @csrf

            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input type="text"
                         id="name"
                         name="name"
                         class="block w-full"
                         value="{{ old('name') }}"
                         required />
                @error('name')
                <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <x-button class="block">
                    Save
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>>
