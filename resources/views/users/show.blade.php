@extends('layouts.app')

@section('content')
    <h1>{{$user->name}}</h1>
    <a class="btn btn-link" href="/{{$user->username}}/follows">
        Sigue a <span class="badge badge-default">{{$user->follows->count()}}</span>
    </a>
    <a class="btn btn-link" href="/{{$user->username}}/followers">
        Seguidores <span class="badge badge-default">{{$user->followers->count()}}</span>
    </a>
    @if(Auth::check())
        @if(Gate::allows('dms', $user))
            <form action="/{{$user->username}}/dms" method="post">
                {{ csrf_field() }}
                <input type="text" name="messages" class="form-control">
                <button type="submit" class="btn btn-success">Enviar DM</button>
            </form>
        @endif
        @if(Auth::user()->isFollowing($user))
            <form action="{{$user->username}}/unfollow" method="post">
                {{ csrf_field() }}
                @if(session('success'))
                    <span class="text-success">{{session('success')}}</span>
                @endif
                <button class="btn btn-danger">Dejar de seguir</button>
            </form>
        @else
            <form action="{{$user->username}}/follow" method="post">
                {{ csrf_field() }}
                @if(session('success'))
                    <span class="text-success">{{session('success')}}</span>
                @endif
                <button class="btn btn-primary">Follow</button>
            </form>
        @endif

    @endif
    <div class="row">
        @foreach($user->messages as $message)
            <div class="col-6">
                @include('messages.message')
            </div>
        @endforeach
    </div>
@endsection