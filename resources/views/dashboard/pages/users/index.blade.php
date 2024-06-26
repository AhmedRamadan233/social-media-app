@extends('dashboard.layouts.dashboard')

@section('title', __('User Page'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> {{ __('User Page') }}</li>
@endsection

@section('content')
    <div class="row">
        @foreach ($users as $user)
            <div class="col-lg-3">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                    <img class="card-img-top" src="{{ asset($user->profile->image) }}" alt="Card image cap">
                    <div class="card-body">
                        <a href="#" class="card-link">{{ $user->name }}</a>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <form action="{{ route('send.friend.request', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add Friend</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
