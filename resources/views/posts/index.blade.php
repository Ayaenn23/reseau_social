@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Fil d'actualité</h4>
        <a href="{{ route('posts.create') }}" class="btn btn-dark btn-sm">+ Nouveau Post</a>
    </div>

    <div id="posts-list">
        @forelse($posts as $post)
        <div class="card shadow-sm mb-3" id="post-{{ $post->id }}">
            {{-- id="post-{{ $post->id }}" : permet à jQuery de cibler
                 cette card spécifique pour la supprimer --}}
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold">{{ $post->title }}</h5>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-muted small mb-2">
                    <i class="fas fa-user"></i> {{ $post->user->name }}
                </p>
                <p class="mb-3">{{ $post->content }}</p>

                <div class="d-flex justify-content-between align-items-center">

                    {{-- Bouton Like AJAX --}}
                    <button class="btn btn-outline-danger btn-sm like-btn"
                            data-post-id="{{ $post->id }}">
                        ❤️ <span class="like-count">{{ $post->likes->count() }}</span>
                    </button>

                    @if(Auth::id() === $post->user_id)
                    <div class="d-flex gap-2">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-warning btn-sm">
                            Modifier
                        </a>

                        {{-- Bouton Supprimer AJAX --}}
                        <button class="btn btn-outline-danger btn-sm delete-btn"
                                data-post-id="{{ $post->id }}">
                            Supprimer
                        </button>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @empty
            <div class="alert alert-info">Aucun post pour le moment.</div>
        @endforelse
    </div>

@endsection

@section('scripts')
<script>

// ============================================
// AJAX LIKE
// ============================================
$(document).on('click', '.like-btn', function() {
    const btn = $(this);
    const postId = btn.data('post-id');

    $.ajax({
        url: `/posts/${postId}/like`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            btn.find('.like-count').text(response.likes_count);
            if (response.liked) {
                btn.removeClass('btn-outline-danger').addClass('btn-danger');
            } else {
                btn.removeClass('btn-danger').addClass('btn-outline-danger');
            }
        },
        error: function() {
            alert('Erreur lors du like !');
        }
    });
});

// ============================================
// AJAX SUPPRIMER
// ============================================
$(document).on('click', '.delete-btn', function() {
    if (!confirm('Supprimer ce post ?')) return;
    // si l'utilisateur clique "Annuler" on arrête tout

    const btn = $(this);
    const postId = btn.data('post-id');

    $.ajax({
        url: `/posts/${postId}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            _method: 'DELETE'
            // Laravel utilise _method pour simuler DELETE
            // car HTML ne supporte pas DELETE nativement
        },
        success: function() {
            $(`#post-${postId}`).fadeOut(400, function() {
                $(this).remove();
                // fadeOut(400) : animation de disparition en 400ms
                // remove() : supprime la card du DOM après l'animation
            });
        },
        error: function() {
            alert('Erreur lors de la suppression !');
        }
    });
});

</script>
@endsection
