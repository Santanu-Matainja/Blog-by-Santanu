@extends('layouts.user')

@section('title', 'Add New Blog')

@section('content')

    <div class="container mt-5">
        <h2>Add New Blog</h2>


        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="my-1">Blog Title</label>
                <input type="text" name="title" class="form-control" required>

                @error('title')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="my-1">Blog Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">

                @error('image')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="my-1">Description</label>
                <textarea name="description" rows="5" class="form-control" required></textarea>

                @error('description')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category" class="form-control" required>
                    @foreach (\App\Models\Blog::categories() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>


                @error('category')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-success my-2">Submit Blog</button>
        </form>
    </div>

@endsection