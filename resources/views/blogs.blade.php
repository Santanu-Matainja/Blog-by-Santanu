<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogs Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
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


            <button type="submit" class="btn btn-primary">Submit Blog</button>
        </form>
    </div>

</body>

</html>