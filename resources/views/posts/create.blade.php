@extends('layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4">Nouveau Post</h4>

        {{-- id="post-form" : jQuery va écouter la soumission de ce formulaire --}}
        <form id="post-form" action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" id="title" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea id="content" name="content" rows="5"
                          class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Zone d'erreurs AJAX --}}
            <div id="ajax-errors" class="alert alert-danger d-none"></div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">Publier</button>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#post-form').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const btn = form.find('button[type="submit"]');

    btn.text('Publication...').prop('disabled', true);


    $('#ajax-errors').addClass('d-none').text('');


    $.ajax({
        url: form.attr('action'),


        method: 'POST',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'


        },

        data: {
            title:   $('#title').val(),
            content: $('#content').val(),

        },

        success: function(response) {

            window.location.href = "{{ route('posts.index') }}";

        },

        error: function(xhr) {
            btn.text('Publier').prop('disabled', false);


            if (xhr.status === 422) {

                const errors = xhr.responseJSON.errors;
                let errorMsg = '';
                $.each(errors, function(key, messages) {
                    errorMsg += messages[0] + '<br>';

                });
                $('#ajax-errors').removeClass('d-none').html(errorMsg);
             
            } else {
                alert('Erreur lors de la publication !');
            }
        }
    });
});
</script>
@endsection
