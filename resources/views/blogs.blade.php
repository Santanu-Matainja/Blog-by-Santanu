<x-app-layout>

    <div class="container mx-auto mt-2 p-4 max-w-2xl">
    <h2 class="text-black text-2xl font-bold mb-4">Add New Blog</h2>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Blog Title -->
        <div>
            <label class="block mb-1 text-black font-medium">Blog Title</label>
            <input type="text" name="title"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                   required>

            @error('title')
                <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
            @enderror
        </div>

        <!-- Blog Image -->
        <div>
            <label class="block mb-1 text-black font-medium">Blog Image</label>
            <input type="file" name="image"
                   class="w-full px-3 py-2 border border-gray-300 rounded bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700"
                   accept="image/*">

            @error('image')
                <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block mb-1 text-black font-medium">Description</label>
            <textarea name="description" rows="5"
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500"
                      required></textarea>

            @error('description')
                <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="block mb-1 text-black font-medium">Category</label>
            <select name="category"
                    class="w-full px-4 py-2 border border-gray-300 rounded bg-white focus:outline-none focus:ring focus:border-blue-500"
                    required>
                @foreach (\App\Models\Blog::categories() as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>

            @error('category')
                <div class="mt-1 text-sm text-red-600 bg-red-100 p-2 rounded">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-black font-semibold rounded hover:bg-green-700 transition">
                Submit Blog
            </button>
        </div>
    </form>
</div>




</x-app-layout>