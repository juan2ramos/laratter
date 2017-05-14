@extends('layouts.app')

@section('content')
    <h1>Conversación con
        {{$conversation->users->except($user->id)->implode('name',', ')}}
    </h1>

    @foreach($conversation->privateMessages as $message)
        <div class="card">
            <div class="card-header">
                <p>{{ $message->user->name }} dijo </p>
            </div>
            <div class="card-block">
                <p>{{ $message->messages }}</p>
            </div>
            <div class="card-footer">
                <p>{{ $message->created_at }}</p>
            </div>
        </div>
    @endforeach

@endsection