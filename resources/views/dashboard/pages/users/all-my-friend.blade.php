@extends('dashboard.layouts.dashboard')

@section('title', __('My Friend Page'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> {{ __('My Friend Page') }}</li>
@endsection

@section('content')
    <div class="row">
        @foreach ($friends as $friend)
            <div class="col-lg-3">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                    <img class="card-img-top" src="{{ asset($friend->profile->image) }}" alt="Card image cap">
                    <div class="card-body">
                        <a href="#" class="card-link">{{ $friend->name }}</a>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        {{-- <form action="{{ route('remove.friend.request', $friend->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form> --}}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
