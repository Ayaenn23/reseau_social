@extends('layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4">Modifier le Post</h4>
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ $post->title }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea name="content" rows="5" class="form-control">{{ $post->content }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">Mettre à jour</button>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
