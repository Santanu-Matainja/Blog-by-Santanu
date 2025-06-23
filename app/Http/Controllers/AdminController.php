<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;


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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && File::exists(public_path('storage/' . $blog->image))) {
                File::delete(public_path('storage/' . $blog->image));
            }

            $user = User::find($blog->user_id);
            $file = $request->file('image');
            $filename = Str::slug($user->name) . '_blog_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $filepath = $file->storeAs('blog_images', $filename, 'public');

            $data['image'] = $filepath;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs')->with('success', 'Blog updated successfully.');
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
            'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('user_photo')) {
            // Delete old photo if exists
            if ($user->user_photo && File::exists(public_path('storage/' . $user->user_photo))) {
                File::delete(public_path('storage/' . $user->user_photo));
            }

            // New photo filename
            $file = $request->file('user_photo');
            $filename = Str::slug($user->name) . '_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $filepath = $file->storeAs('user_photos', $filename, 'public');

            $user->user_photo = $filepath;
        }

        $user->save();

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
