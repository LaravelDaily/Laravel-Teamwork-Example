<x-app-layout>
    <x-slot name="header">
        Tasks List
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-xs">

        <a class="inline-flex px-4 py-2 mb-4 text-sm font-medium text-white bg-purple-600 rounded-lg border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring" href="{{ route('tasks.create') }}">
            Create task
        </a>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Task</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($tasks as $task)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-sm w-1">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $task->name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-3 text-sm" colspan="2">
                                Your team <span class="tracking-wide">{{ auth()->user()->currentTeam->name }}</span> has no tasks.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $tasks->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
