<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // Afficher tous les posts
    public function index()
    {
        $posts = Post::with(['user', 'likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Formulaire de création
    public function create()
    {
        return view('posts.create');
    }

    // Sauvegarder un post
public function store(Request $request)
{
    $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    Post::create([
        'title'   => $request->title,
        'content' => $request->content,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('posts.index')->with('success', 'Post créé !');
}
    // Afficher un post
    public function show(Post $post)
    {

    }

    // Formulaire de modification
    public function edit(Post $post)
    {

        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    // Mettre à jour un post
    public function update(Request $request, Post $post)
    {

        $this->authorize('update', $post);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->only('title', 'content'));

        return redirect()->route('posts.index')->with('success', 'Post modifié avec succès !');
    }

    // Supprimer un post
    public function destroy(Post $post)
    {

    $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès !');
    }

    // Liker / Unliker un post (AJAX)
    public function like(Post $post)
    {
        $userId = Auth::id();
        $like = Like::where('user_id', $userId)->where('post_id', $post->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $userId,
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked'      => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }
}


















// public function like(Post $post)
// {
//     $like = Like::where('user_id', Auth::id())
//                 ->where('post_id', $post->id)
//                 ->first();

//     if ($like) {
//         $like->delete();
//     } else {
//         Like::create([
//             'user_id' => Auth::id(),
//             'post_id' => $post->id,
//         ]);
//     }

//     return redirect()->route('posts.index');
// }
// }
