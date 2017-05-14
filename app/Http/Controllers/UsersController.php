<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Notifications\UserFollowed;
use App\PrivateMessage;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($username)
    {
        $user = $this->findByUsername($username);
        return view('users.show', compact('user'));
    }

    public function follows($username)
    {
        $user = $this->findByUsername($username);
        $follows = $user->follows;
        return view('users.follows', compact('user', 'follows'));
    }

    public function sendPrivateMessage($username, Request $request)
    {
        $user = $this->findByUsername($username);

        $me = $request->user();
        $message = $request->input('messages');

        $conversation = Conversation::between($me,$user);

        PrivateMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $me->id,
            'messages' => $message,
        ]);
        return redirect('conversations/' . $conversation->id);

    }

    public function followers($username)
    {
        $user = $this->findByUsername($username);
        $follows = $user->followers;
        return view('users.follows', compact('user', 'follows'));
    }

    public function follow($username, Request $request)
    {
        $user = $this->findByUsername($username);
        $me = $request->user();
        $me->follows()->attach($user);

        $user->notify(new UserFollowed($me));

        return redirect("/$username")->withSuccess('Usuario seguido');
    }

    public function unfollow($username, Request $request)
    {
        $user = $this->findByUsername($username);
        $me = $request->user();
        $me->follows()->detach($user);
        return redirect("/$username")->withSuccess('Usuario no seguido');
    }

    private function findByUsername($username)
    {
        return User::where('username', $username)->firstOrFail();
    }

    public function showConversation(Conversation $conversation)
    {
        $conversation->load('users', 'privateMessages');
        $user = auth()->user();
        return view('users.conversation', compact('conversation', 'user'));
    }
    public function notifications(Request $request)
    {
        return $request->user()->notifications;
    }
}
