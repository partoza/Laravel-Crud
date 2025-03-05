<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.store') }}" hx-target="body" hx-swap="outerHTML">>
            @csrf
            <textarea name="message" placeholder="{{ __('Post a task') }}"
                class="block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50 rounded-md shadow-sm p-2">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Post')}}</x-primary-button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($tasks as $task)
                <div class="p-6 flex space-x-3">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5-6h-4.586a2 2 0 00-1.414.586L12 5H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2z" />
                    </svg>

                    <div class="flex-1">
                        <!-- Task Header -->
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold">{{ $task->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-500">{{ $task->created_at->format('j M Y, g:i a') }}</small>

                                @unless ($task->created_at->eq($task->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>

                            <!-- Status Badge & Dropdown -->
                            <div class="flex items-center space-x-2">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 text-sm font-semibold text-white rounded-lg 
                                            {{ $task->status === 'pending' ? 'bg-yellow-500' : 'bg-green-500' }}">
                                    {{ ucfirst($task->status) }}
                                </span>

                                <!-- Dropdown (Only for Task Owner) -->
                                @if ($task->user->is(auth()->user()))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('tasks.edit', $task)" hx-boost="true"
                                                hx-push-url="true">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('tasks.destroy', $task)}}" hx-target="body" 
                                            hx-swap="outerHTML">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('tasks.destroy', $task)"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                            </div>
                        </div>

                        <!-- Task Message -->
                        <p class="mt-4 text-lg text-gray-900">{{ $task->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</x-app-layout>