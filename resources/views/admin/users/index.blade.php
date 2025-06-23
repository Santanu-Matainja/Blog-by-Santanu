@extends('layouts.admin')

@section('title', 'See User')

@section('content')

    @section('togglebtn')
        <a href="{{ route('admin.blogs') }}" class="logout-btn">
            <span>View Blog's</span>
        </a>
    @endsection

    <div class="container">

        <div class="d-flex justify-content-between my-2">
            <h2 class="text-white">All Users</h2>

            <a href="{{ route('register.form') }}" class="btn btn-success">Add User</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->user_photo)
                                <img src="{{ asset('storage/' . $user->user_photo) }}" width="40" height="40"
                                    class="rounded-circle">
                            @else
                                <span>No photo</span>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->user_type ?? 'user') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            @if ($user->user_type = 'admin')
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure to delete?')"
                                        class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection