<x-app-layout>
    <x-slot name="header">
        Teams
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <a class="inline-flex px-4 py-2 mb-4 text-sm font-medium text-white bg-purple-600 rounded-lg border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring" href="{{ route('teams.create') }}">
            Create team
        </a>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($teams as $team)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">{{ $team->name }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if(auth()->user()->isOwnerOfTeam($team))
                                        <span class="px-2 py-1 text-green-700 bg-green-200 rounded-xl">Owner</span>
                                    @else
                                        <span class="px-2 py-1 text-indigo-700 bg-indigo-200 rounded-xl">Member</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !== $team->getKey())
                                        <a href="{{ route('teams.switch', $team) }}" class="px-2 py-1 mr-2 text-indigo-700 bg-indigo-200 rounded-xl hover:bg-indigo-300 hover:text-indigo-800">
                                            Switch
                                        </a>
                                    @else
                                        <span class="px-2 py-1 text-green-700 bg-green-200 rounded-xl">Current team</span>
                                    @endif

                                    <a href="{{route('teams.members.show', $team)}}" class="inline-flex px-2 py-1 text-sm font-medium text-white bg-purple-600 rounded-lg border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring">
                                        Members
                                    </a>

                                    @if(auth()->user()->isOwnerOfTeam($team))

                                        <a href="{{ route('teams.edit', $team) }}" class="inline-flex px-2 py-1 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg border border-transparent active:bg-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                            Edit
                                        </a>

                                        <form class="inline-block" action="{{ route('teams.destroy', $team) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex px-2 py-1 text-sm font-medium text-red-600 bg-red-200 rounded-lg border border-transparent active:bg-red-600 hover:bg-red-300 focus:outline-none focus:ring">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>>
