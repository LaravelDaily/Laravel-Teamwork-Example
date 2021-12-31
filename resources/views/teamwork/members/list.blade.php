<x-app-layout>
    <x-slot name="header">
        Members of team <span class="tracking-wide">{{ $team->name }}</span>
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">
        <a href="{{ route('teams.index') }}" class="inline-flex px-4 py-2 mb-4 text-sm font-medium text-white bg-purple-600 rounded-lg border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring">
            Back
        </a>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($team->users as $user)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if(auth()->user()->isOwnerOfTeam($team))
                                        @if(auth()->user()->getKey() !== $user->getKey())
                                            <form class="inline-block" action="{{ route('teams.members.destroy', [$team, $user]) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <x-button>
                                                    Delete
                                                </x-button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(auth()->user()->isOwnerOfTeam($team))

            <h3 class="mb-3 text-lg font-semibold tracking-wide">Pending invitations</h3>

            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">E-Mail</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        @foreach($team->invites as $invite)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">{{ $invite->email }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{route('teams.members.resend_invite', $invite)}}" class="inline-flex px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring">
                                        Resend invite
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h3 class="mb-3 text-lg font-semibold tracking-wide">Invite to team "{{ $team->name }}"</h3>

            <form class="form-horizontal" method="post" action="{{route('teams.members.invite', $team)}}">
                @csrf

                <div>
                    <x-label for="email" :value="__('Email')" />
                    <x-input type="text"
                             id="email"
                             name="email"
                             class="block w-full"
                             value="{{ old('email') }}"
                             required />
                    @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400">
                    {{ $message }}
                </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-button class="block">
                        Invite to Team
                    </x-button>
                </div>
            </form>

        @endif
    </div>
</x-app-layout>>
