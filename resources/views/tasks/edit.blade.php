<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form hx-post="{{ route('tasks.update', $task) }}" hx-target="body" hx-swap="outerHTML" hx-push-url="{{ route('tasks.index')}}">
            @csrf
            @method('patch')

            <!-- Task Message -->
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $task->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <!-- Task Status Dropdown -->
            <div class="mt-4">
                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                <select
                    name="status"
                    id="status"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>
                        {{ __('Pending') }}
                    </option>
                    <option value="complete" {{ old('status', $task->status) === 'complete' ? 'selected' : '' }}>
                        {{ __('Complete') }}
                    </option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a  href="{{ route('tasks.index') }}" hx-boost="true" hx-push-url="{{ route('tasks.index')}}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
