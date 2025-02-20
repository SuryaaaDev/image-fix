<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $client = new Client();
        $url = "http://localhost:8001/api/posts";
        $response = $client->request('GET', $url);
        $postJson = $response->getBody()->getContents();
        // dd($postJson);
        $postArray = json_decode($postJson, true)['data'];

        return view('posts.index', compact('postArray'));
    }

    public function create()
    {
        $post = Post::all();

        return view('posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:300',
            'content' => 'required|min:3|max:3048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paramenter = [
            'title' => $request['title'],
            'content' => $request['content'],
        ];

        // upload image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $paramenter['image'] = $imagePath;
        }

        $client = new Client();
        $url = "http://localhost:8001/api/posts";
        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name'     => 'title',
                    'contents' => $paramenter['title'],
                ],
                [
                    'name'     => 'content',
                    'contents' => $paramenter['content'],
                ],
                [
                    'name'     => 'image', // Nama field untuk file gambar
                    'contents' => fopen(storage_path('app/public/' . $paramenter['image']), 'r'),
                    'filename' => basename($paramenter['image']),
                ],
            ],
        ]);

        return redirect()->intended('/index');
    }

    public function show($id)
    {
        $client = new Client();
        $url = "http://localhost:8001/api/posts/{$id}";
        $response = $client->request('GET', $url);
        $postJson = $response->getBody()->getContents(); // Membaca dan mengembalikan body tersebut sebagai string.
        $postArray = json_decode($postJson, true)['data']; //string JSON diubah menjadi array PHP

        return view('posts.show', compact('postArray')); //compact mengirim data ke view
    }

    public function edit($id)
    {
        $client = new Client();
        $url = "http://localhost:8001/api/posts/{$id}";
        $response = $client->request('GET', $url);
        $postJson = $response->getBody()->getContents(); 
        $postArray = json_decode($postJson, true)['data']; 

        return view('posts.edit', compact('postArray')); 
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:300',
            'content' => 'required|min:3|max:3048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paramenter = [
            'title' => $request->input('title'), // Lebih aman dan konsisten
            'content' => $request->input('content'),
        ]; 
        
        //image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $paramenter['image'] = $imagePath;
        }

        $client = new Client();
        $url = "http://localhost:8001/api/posts/{$id}";
        $response = $client->request('PUT', $url, [
            'json' => $paramenter,
        ]);

        return redirect()->intended('/index');
    }    

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://localhost:8001/api/posts/{$id}";
        $response = $client->request('DELETE', $url);

        return redirect()->intended('/index');
    }
}
