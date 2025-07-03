<x-app-layout>

    <div class="container mx-auto mt-2 p-4 max-w-2xl">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Edit Blog</h2>

        <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Show current image preview --}}
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="mb-2 object-cover border rounded"
                    style="max-height: 200px; max-width: 200px;">
            @endif

            <!-- Upload New Image -->
            <div>
                <label for="image" class="block text-gray-700 font-medium mb-1">Upload New Image</label>
                <input type="file" name="image"
                    class="w-full px-4 py-2 border border-gray-300 rounded bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700"
                    accept="image/*" onchange="previewImage(event)">
            </div>

            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ $blog->title }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">{{ $blog->description }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-row justify-between">
                <a href="{{route('admin.blogs')}}" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">Back</a>

                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                    Update Blog
                </button>
            </div>
        </form>
    </div>




    @push('scripts')
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const imgPreview = document.createElement('img');
                    imgPreview.src = reader.result;
                    imgPreview.style.maxHeight = "200px";
                    imgPreview.style.maxWidth = "200px";
                    imgPreview.style.objectFit = "cover";

                    const existingPreview = document.getElementById("image-preview");
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    imgPreview.id = "image-preview";
                    event.target.parentNode.appendChild(imgPreview);
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    @endpush

</x-app-layout>
