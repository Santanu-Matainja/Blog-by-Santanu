<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.edit', compact('blog'));
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
}

