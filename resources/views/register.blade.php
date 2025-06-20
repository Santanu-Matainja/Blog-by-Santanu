<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4">Sign Up</h2>

        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}" autocomplete="off">

                @error('name')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}"  autocomplete="off" >

                @error('email')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}"  autocomplete="off" required>

                @error('password')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" autocomplete="off"  required>

                @error('password_confirmation')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>User Photo</label>
                <input type="file" name="user_photo" class="form-control" accept="image/*" value="{{ old('user_photo') }}">

                @error('user_photo')
                    <div class="m-1 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    

</div>
</body>
</html>
