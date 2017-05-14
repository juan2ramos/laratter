<?php

namespace App\Http\Controllers;

use App\SocialProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function callback(){

        $user = Socialite::driver('facebook')->user();

        $existing = User::whereHas('socialProfile',function ($q) use ($user){
            $q->where('social_id',$user->id);
        })->first();
        if($existing !== null){
            auth()->login($existing);
            return redirect('/');
        }
        Session()->flash('facebookUser',$user);
        return view('users.facebook',compact('user'));
    }
    public function register(Request $request){
        $data = session('facebookUser');
        $username = $request->input('username');
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'avatar' => $data->avatar,
            'username' => $username,
            'password' => str_random(16),
        ]);
        SocialProfile::create([
            'social_id' => $data->id,
            'user_id' => $user->id,
        ]) ;
        auth()->login($user);
        return redirect('/');
    }
}
