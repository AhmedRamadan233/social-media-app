@extends('dashboard.layouts.dashboard')

@section('title', __('User Page'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> {{ __('User Page') }}</li>
@endsection

@section('content')
    <div class="row">
        @foreach ($requestsToBeFriends as $requestsToBeFriend)
            <div class="col-lg-3">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                    <img class="card-img-top" src="{{ asset($requestsToBeFriend->sender->profile->image) }}" alt="Card image cap">
                    <div class="card-body">
                        <a href="#" class="card-link">{{ $requestsToBeFriend->sender->name }}</a>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <form action="{{ route('accept.friend.request', $requestsToBeFriend->sender->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Accept</button>
                        </form>
                        <form action="{{ route('remove.friend.request', $requestsToBeFriend->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
