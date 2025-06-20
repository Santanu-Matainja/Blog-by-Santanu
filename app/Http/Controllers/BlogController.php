<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $categories = Blog::categories();
        $blogs = Blog::with('user')->latest()->get();
        $user = Auth::user();
        return view('dashboard', compact('blogs', 'user', 'categories'));
    }

    public function create()
    {
        return view('blogs');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'category' => 'required|in:1,2,3,4',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $timestamp = Carbon::now()->format('Ymd_His');
            $username = Str::slug(Auth::user()->name);
            $filename = $username . '_blog_' . $timestamp . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('blog_images', $filename, 'public');
        }

        Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        return redirect()->route('dashboard');
    }


    public function destroy(Blog $blog)
    {
        if (Auth::id() !== $blog->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($blog->image && \Storage::disk('public')->exists($blog->image)) {
            \Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('dashboard')->with('success', 'Blog deleted successfully.');
    }

    public function ajaxToggleLike(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $user = auth()->user();

        $liked = $user->liked_blogs ? json_decode($user->liked_blogs, true) : [];

        $likedThis = in_array($id, $liked);

        if ($likedThis) {
            if ($blog->likes > 0) {
                $blog->decrement('likes');
            }
            $liked = array_diff($liked, [$id]);
        } else {
            $blog->increment('likes');
            $liked[] = $id;
        }

        $user->liked_blogs = json_encode(array_values($liked));
        $user->save();

        return response()->json([
            'status' => 'success',
            'liked' => !$likedThis,
            'likes' => $blog->likes,
        ]);
    }
}
