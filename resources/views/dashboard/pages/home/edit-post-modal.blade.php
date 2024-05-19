  <!-- Comment Modal -->
  <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="commentModalLabel">Add a Comment</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="editPostForm" action="{{ route('posts.update', ['id' => ':id']) }}" method="POST"
                      enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" id="post_id" name="post_id">
                      <div class="form-group">
                          <label for="content">Your Post</label>
                          <textarea class="form-control content" id="content" name="content" rows="3"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Post</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
