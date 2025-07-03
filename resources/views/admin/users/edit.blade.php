<x-app-layout>


    <div class="container mx-auto mt-10 p-4 max-w-lg">
    <h2 class="text-2xl font-bold text-black mb-6">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-black mb-1">Name</label>
            <input type="text" name="name" value="{{ $user->name }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500 bg-white"
                   required>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-black mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500 bg-white"
                   required>
        </div>

        <!-- Current Photo -->
        <div>
            <label class="block text-black mb-1">Current Photo</label>
            @if ($user->user_photo)
                <img src="{{ asset('storage/' . $user->user_photo) }}" width="100" class="mb-2 rounded shadow">
            @else
                <p class="text-black italic">No photo uploaded</p>
            @endif
        </div>

        <!-- Upload New Photo -->
        <div>
            <label class="block text-black mb-1">New Photo (Optional)</label>
            <input type="file" name="user_photo"
                   class="w-full px-4 py-2 border border-gray-300 rounded bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700">
        </div>

        <!-- Actions -->
        <div class="flex justify-between">
            <a href="{{ route('admin.users') }}"
            class="bg-green-500 hover:bg-green-600 text-black px-5 py-2 rounded font-semibold">
            Cancel
        </a>

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-black px-5 py-2 rounded font-semibold">
            Update User
        </button>
        </div>
    </form>
</div>


</x-app-layout>
