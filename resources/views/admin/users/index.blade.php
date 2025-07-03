<x-app-layout>

    <div class="container mx-auto p-4 mt-4">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-black text-2xl font-bold">All Users</h2>
            <a href="{{ route('register.form') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold">
                Add User
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Photo</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">User Type</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">
                                @if ($user->user_photo)
                                    <img src="{{ asset('storage/' . $user->user_photo) }}" width="40" height="40"
                                        class="rounded-full object-cover">
                                @else
                                    <span class="text-gray-500 italic">No photo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ ucfirst($user->user_type ?? 'user') }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-black text-xs px-3 py-1 rounded">
                                    Edit
                                </a>

                                @if ($user->user_type = 'admin')
                                    <button onclick="openDeleteModal({{ $user->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-black text-xs px-3 py-1 rounded">
                                        Delete
                                    </button>

                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this user? This action cannot be undone.</p>

            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>

                <button id="confirm-delete-button" class="px-4 py-2 bg-red-600 text-black rounded hover:bg-red-700">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let deleteFormId = null;

            function openDeleteModal(userId) {
                deleteFormId = 'delete-form-' + userId;
                document.getElementById('confirm-modal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('confirm-modal').classList.add('hidden');
                deleteFormId = null;
            }

            document.getElementById('confirm-delete-button').addEventListener('click', function() {
                if (deleteFormId) {
                    document.getElementById(deleteFormId).submit();
                }
            });
        </script>
    @endpush

</x-app-layout>
