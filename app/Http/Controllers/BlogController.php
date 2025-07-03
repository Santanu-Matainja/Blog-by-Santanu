<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BlogRequest;


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
        $user = Auth::user();
        return view('blogs', compact('user'));
    }

    public function store(BlogRequest $request)
    {
        $request->validated();

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $timestamp = Carbon::now()->format('Ymd_His');
            $username = Str::slug(Auth::user()->name);
            $filename = $username . '_blog_' . $timestamp . '.' . $file->getClientOriginalExtension();
            $imagePath = Storage::disk('public')->putFileAs('blog_images', $file, $filename);
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
