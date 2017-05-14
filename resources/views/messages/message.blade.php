<img class="img-thumbnail" src="{{ $message->image }}">
<p class="card-text">
    <span class="text-muted">Escrito por el usuario
        <a href="/{{$message->user->username}}">{{$message->user->username}}</a>
    </span>
    {{$message->content}}
    <a href="message/{{$message->id}}">Leer más</a>
</p>
<div class="card-text text-muted float-right">
    {{$message->created_at}}
</div>
