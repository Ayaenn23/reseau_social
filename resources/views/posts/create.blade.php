@extends('layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4">Nouveau Post</h4>
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Publier</button>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
