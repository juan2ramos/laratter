@extends('layouts.app')

@section('content')
    <h1>{{$user->name}}</h1>
    <div class="row">
        <ul class="list-unstyled">
            @foreach($follows as $follow)
                <li>{{$follow->username}}</li>
            @endforeach
        </ul>
    </div>
@endsection