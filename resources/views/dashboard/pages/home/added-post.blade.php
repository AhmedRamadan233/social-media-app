<div class="container mt-5">
    <!-- Section for creating a new post -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Create a New Post</h5>
            <form id="createPostForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" id="postContent" rows="3" placeholder="What's on your mind?"></textarea>
                </div>
                {{-- <div class="form-group">
                    <input type="file" class="form-control-file" id="postImage" name="image">
                </div> --}}
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>

    <!-- Section for displaying posts -->
    @foreach ($posts as $post)
        <div class="card mb-4">
            <div class="card-body">
                <div class="media">
                    <img src="{{ asset($post->user->profile->image) }}" class="img-circle " alt="User Image"
                        style="width: 64px; height: 64px;">
                    <div class="media-body">
                        <h5 class="mt-0">{{ $post->user->name }}</h5>
                        <p>{{ $post->content }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($post->user->id === Auth::user()->id)
                                <div>

                                    <button type="button" class="btn btn-outline-primary btn-sm mr-2"
                                        onclick="editPostModal({{ $post->id }})">
                                        Edit Post
                                    </button>

                                    <button type="button" class="btn btn-icon btn-danger"
                                        onclick="confirmDelete('{{ $post->id }}')">
                                        Delete
                                    </button>

                                </div>
                            @endif
                            <div>
                                @php
                                    $isLiked = $post->likes()->where('user_id', auth()->id())->exists();
                                @endphp
                                <form id="like-form-{{ $post->id }}" action="{{ route('likes.toggle') }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="button"
                                        class="btn {{ $isLiked ? 'btn-secondary' : 'btn-outline-secondary' }} btn-sm mr-2 like-button"
                                        data-post-id="{{ $post->id }}">
                                        {{ $isLiked ? 'Unlike' : 'Like' }}
                                    </button>
                                </form>
                                <span class="badge badge-primary">{{ $post->likes->count() }}</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                    data-target="#commentModal"
                                    onclick="addedCommentModal({{ $post->id }})">Comment</button>
                                <span class="badge badge-primary">{{ $post->comments->count() }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6>Liked by:</h6>
                            <ul class="list-inline">
                                @foreach ($post->likes as $like)
                                    <li class="list-inline-item"><img src="{{ asset($like->user->profile->image) }}"
                                            class="rounded-circle" alt="{{ $like->user->name }}" style="width: 32px; height: 32px;">
                                    </li>
                                @endforeach


                            </ul>
                        </div>
                        <div class="mt-3">
                            <h6>Comments:</h6>
                            <ul class="list">
                                @foreach ($post->comments as $comment)
                                    <li>
                                        <h6>{{ $comment->content }}</h6>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
