<x-app-layout>

    <div class="container mx-auto mt-10 p-4 max-w-lg">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Sign Up</h2>

            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                        required value="{{ old('name') }}" autocomplete="off">

                    @error('name')
                        <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                        required value="{{ old('email') }}" autocomplete="off">

                    @error('email')
                        <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                        required autocomplete="off" value="{{ old('password') }}">

                    @error('password')
                        <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                        required autocomplete="off" value="{{ old('password_confirmation') }}">

                    @error('password_confirmation')
                        <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
                    @enderror
                </div>

                <!-- User Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">User Photo</label>
                    <input type="file" name="user_photo"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700"
                        accept="image/*">

                    @error('user_photo')
                        <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-between">
                    
                    <a href="{{route('admin.users')}}" class=" bg-green-600 text-white font-semibold py-2 px-4 rounded hover:bg-green-700 transition">Back</a>
                    <button type="submit"
                        class=" bg-green-600 text-white font-semibold py-2 px-4 rounded hover:bg-green-700 transition">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
