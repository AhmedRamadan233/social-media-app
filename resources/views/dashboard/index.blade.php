@extends('dashboard.layouts.dashboard')

@section('title', '')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{__('Starter Page')}}</li>
@endsection

@section('content')
<div class="row">
    
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <div class="media">
          <img src="profile_picture.jpg" class="mr-3 rounded-circle" alt="Profile Picture" style="width: 64px; height: 64px;">
          <div class="media-body">
            <h5 class="mt-0">Author Name</h5>
            <p>Post content goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <p class="text-muted">Creation Date: May 18, 2024</p>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <button type="button" class="btn btn-outline-primary btn-sm mr-2">Edit</button>
                <button type="button" class="btn btn-outline-danger btn-sm">Delete</button>
              </div>
              <div>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2">Like</button>
                <span class="badge badge-primary">10</span>
                <button type="button" class="btn btn-outline-secondary btn-sm">Comment</button>
                <span class="badge badge-primary">5</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
        
  </div>
  <!-- /.row -->
@endsection



