@extends('dashboard.layouts.dashboard')

@section('title', '')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('Starter Page') }}</li>
@endsection

@section('content')
    <div class="row" id="postsCard">
        @include('dashboard.pages.home.added-post')

        @include('dashboard.pages.home.added-comment')
        @include('dashboard.pages.home.edit-post-modal')
        @include('dashboard.pages.home.confirm-delete-modal')


    </div>
    <!-- /.row -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#createPostForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        // $('#createPictureModal').modal('hide');
                        $('#postsCard').load(location.href + ' #postsCard>*', '');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function addedCommentModal(postId) {
            $.ajax({
                url: '/dashboard/comments/' + postId,
                type: 'GET',
                success: function(response) {
                    console.log(response.postId);
                    $('#commentModal').modal('show');
                    $('#post_id').val(response.postId);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }


        function editPostModal(postId) {
            $.ajax({
                url: '/dashboard/comments/' + postId,
                type: 'GET',
                success: function(response) {
                    $('#editPostModal').modal('show');
                    $('#post_id').val(response.postId);
                    $('#content').val(response.postContent);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function() {
            $('#editPostForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                var postId = $('#post_id').val(); // Get the post ID from the hidden input field
                $.ajax({
                    url: $(this).attr('action').replace(':id',
                        postId), // Include the post ID in the URL
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        $('#postsCard').load(location.href + ' #postsCard>*', '');
                        $('#editPostModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });















        $(document).ready(function() {
            $('#createCommentForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        $('#postsCard').load(location.href + ' #postsCard>*', '');
                        $('#commentModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        })


        function confirmDelete(postId) {
            $('#confirmDeleteModal').modal('show'); // Show the modal

            $('#confirmDeleteBtn').off('click').on('click', function() { // Ensure previous click handlers are removed
                $.ajax({
                    url: "{{ route('posts.destroy', '__postId__') }}".replace('__postId__', postId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        $('#confirmDeleteModal').modal('hide'); // Hide the modal
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        }



        $(document).ready(function() {
            $('.like-button').on('click', function() {
                var button = $(this);
                var postId = button.data('post-id');
                var form = $('#like-form-' + postId);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            button.toggleClass('btn-outline-secondary btn-secondary');
                            button.text(response.isLiked ? 'Unlike' : 'Like');
                           
                        }
                    }
                });
            });
        });
    </script>
@endpush
