@extends('layouts.admin')

@section('title', 'Admin Edit')

@section('content')

    <div class="container mt-2">
        <h2 class="mb-1">Edit Blog</h2>

        <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}">
            @csrf
            @method('PUT')

            {{-- Show current image preview --}}
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top m-2"
                    style="max-height: 200px; max-width: 200px; object-fit: fill;">
            @endif

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

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $blog->title }}">
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $blog->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-success mb-1">Update Blog</button>
        </form>
    </div>




@endsection

@push('scripts')
    <script>
        const fileInput = document.getElementById('imageInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');

        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                fileNameDisplay.value = this.files[0].name;
            }
        });
    </script>
@endpush