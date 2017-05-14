<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Message;
use Illuminate\Http\Request;


class MessagesController extends Controller
{
    public function show(Message $message){
        return view('messages.show',compact('message'));
    }
    public function create(CreateMessageRequest $request){

        $user = $request->user();

        $image = $request->file('image');

        Message::create([
            'user_id' => $user->id,
            'content' => $request->input('message'),
            'image' => $image->store('messages','public'),
        ]);
        return redirect()->back()->with(['ok' => 'ds']);
    }
    public function search(Request $request){
        $query = $request->input('query');
        /*$messages = Message::with('user')->where('content','LIKE',"%$query%")->get();*/
        $messages = Message::search($query)->get();
        $messages->load('user');
        return view('messages.index',compact('messages'));
    }
    public function responses(Message $message){

        return $message->responses;

    }

}
