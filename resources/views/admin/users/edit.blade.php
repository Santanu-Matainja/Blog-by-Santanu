@extends('layouts.admin')

@section('title', 'See User')

@section('content')

    @section('togglebtn')
        <a href="{{ route('admin.blogs') }}" class="logout-btn">
            <span>View Blog's</span>
        </a>
    @endsection

<div class="container">
    <h2 class="text-white">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="text-white my-1">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="text-white my-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        
        <button type="submit" class="btn btn-success my-2">Update User</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary my-2">Cancel</a>
    </form>
</div>
@endsection
