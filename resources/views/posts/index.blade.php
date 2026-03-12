@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Fil d'actualité</h4>
        <a href="{{ route('posts.create') }}" class="btn btn-dark btn-sm">+ Nouveau Post</a>
    </div>

    @forelse($posts as $post)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold">{{ $post->title }}</h5>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
            <p class="text-muted small mb-2"><i class="fas fa-user"></i> {{ $post->user->name }}</p>
            <p class="mb-3">{{ $post->content }}</p>

            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('posts.like', $post) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        ❤️ {{ $post->likes->count() }} 
                    </button>
                </form>

                @if(Auth::id() === $post->user_id)
                <div class="d-flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-warning btn-sm">✏️ Modifier</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Supprimer ce post ?')">🗑️ Supprimer</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
        <div class="alert alert-info">Aucun post pour le moment.</div>
    @endforelse
@endsection
