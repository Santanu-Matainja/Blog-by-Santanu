<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Edit</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Blog</h2>

        <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="imageInput" class="form-label">Image</label>

                {{-- Fake input to show existing file name --}}
                <input type="text" class="form-control mb-2" id="fileNameDisplay"
                    value="{{ $blog->image ? basename($blog->image) : '' }}" readonly>

                {{-- Real file input, hidden --}}
                <input type="file" name="image" class="form-control" id="imageInput" accept="image/*"
                    style="display: none;">

                <button type="button" class="btn btn-secondary mt-2"
                    onclick="document.getElementById('imageInput').click()">Choose New Image</button>
            </div>

            {{-- Show current image preview --}}
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top m-2"
                    style="max-height: 200px; max-width: 200px; object-fit: fill;">
            @endif

            <script>
                const fileInput = document.getElementById('imageInput');
                const fileNameDisplay = document.getElementById('fileNameDisplay');

                fileInput.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        fileNameDisplay.value = this.files[0].name;
                    }
                });
            </script>


            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $blog->title }}">
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $blog->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Blog</button>
        </form>
    </div>
</body>

</html>