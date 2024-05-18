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
                    <img src="{{ asset(auth()->user()->profile->image) }}" class="img-circle " alt="User Image"
                        style="width: 64px; height: 64px;">
                    <div class="media-body">
                        <h5 class="mt-0">{{ $post->user->name }}</h5>
                        <p>{{ $post->content }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-sm mr-2">Edit</button>
                                <button type="button" class="btn btn-outline-danger btn-sm">Delete</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary btn-sm mr-2 like-button">
                                    Like
                                </button>
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
                                <li class="list-inline-item"><img src="user1.jpg" class="rounded-circle" alt="User 1"
                                        style="width: 32px; height: 32px;"></li>
                                <li class="list-inline-item"><img src="user2.jpg" class="rounded-circle" alt="User 2"
                                        style="width: 32px; height: 32px;"></li>
                                <!-- Add more users as needed -->
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
