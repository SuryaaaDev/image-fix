<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostApiContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        // return response()->json(['status' => true, 'data' => $posts, 'message' => 'Lihat Semua Data']); 
        return response()->json([
            'status' => true,
            'data' => $posts,
            'message' => 'All Post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }
        $post->save();

        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Post Created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Post ID',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        
        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image && Storage::exists('public/' . $post->image)) {
                Storage::delete('public/' . $post->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();
        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Post Updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        // Hapus gambar jika ada
        if ($post->image && Storage::exists('public/' . $post->image)) {
            Storage::delete('public/' . $post->image);
        }
        $post->delete();

        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Post Deleted',
        ]);
    }
}
