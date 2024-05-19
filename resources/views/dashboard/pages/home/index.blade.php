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
        @include('dashboard.pages.home.edit-comment')

    </div>
    <!-- /.row -->
@endsection
@push('scripts')
    <script>
        function toggleLike(button) {
            if (button.classList.contains('btn-outline-secondary')) {
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-secondary');
                button.textContent = 'Liked';
            } else {
                button.classList.remove('btn-secondary');
                button.classList.add('btn-outline-secondary');
                button.textContent = 'Like';
            }
        }

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


        function editCommentModal(postId) {
            $.ajax({
                url: '/dashboard/comments/' + postId,
                type: 'GET',
                success: function(response) {
                    $('#editCommentModal').modal('show');
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
                        $('#editCommentModal').modal('hide');
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
    </script>
@endpush
