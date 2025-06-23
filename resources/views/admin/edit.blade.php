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
                <label for="image">Upload New Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush