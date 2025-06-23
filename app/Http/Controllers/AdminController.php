<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
  
class AdminController extends Controller
{
    public function index()
    {
        $categories = Blog::categories();
        $user = Auth::user();
        $blogs = Blog::with('user')->latest()->get();
        return view('admin.index', compact('blogs', 'categories', 'user'));
    }

    public function edit(Blog $blog)
    {
        $user = Auth::user();
        return view('admin.edit', compact('blog', 'user'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $blog->update($request->only('title', 'description'));

        return redirect()->route('admin.blogs')->with('success', 'Blog updated');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && \Storage::disk('public')->exists($blog->image)) {
            \Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return back()->with('success', 'Blog deleted');
    }


    // Show all users
    public function users()
    {
        $users =  User::where('user_type', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    // Show edit form
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_type === 'admin') {
            return back()->with('error', 'Cannot delete another admin.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
