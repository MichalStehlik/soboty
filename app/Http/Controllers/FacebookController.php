<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;

class FacebookController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        if ($user)
        {
            $token = $user->token;
            $user->getName();
            $user->getEmail(); 

            $userRecord = User::where('fb_id', $user->getId())->first();
            if ($userRecord)
            {
                Auth::loginUsingId($userRecord->id, false);
                flash("Proběhlo přihlášení prostřednictvím Facebooku.")->success();
                return redirect()->intended('');
            }
            else
            {
                $splitName = explode(' ', $user->getName(), 2);
                $firstname = $splitName[0];
                $lastname = !empty($splitName[1]) ? $splitName[1] : '';
                return view('facebook.create',["fb_id" => $user->getId(),"email" => $user->getEmail(),"firstname" => $firstname,"lastname" => $lastname]);
            }            
        }
        else
        {
            flash("Získání informací z Facebooku se nepodařilo.")->danger();
            return \Redirect::route('home');
        }
    }

    public function store()
    {
        $this->validate(request(),[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "birthdate" => "required",
            "gender" => "required",
            "email" => "required|email|unique:users",
            "fb_id" => "required",
        ]);

        $user = User::create([
            "firstname" => request("firstname"),
            "lastname" => request("lastname"),
            "birthdate" => request("birthdate"),
            "gender" => request("gender"),
            "email" => request("email"),
            "school" => request("school"),
            "year" => request("year"),
            "fb_id" => request("fb_id"),
            "password" => bcrypt(str_random(20)),
            "keep_informed" => (bool)(request("keep_informed","0")),
            "potential_student" => (bool)(request("potential_student","0")),
        ]);
        flash("Uživatel byl založen prostřednictvím podkytnutých údajů.")->success();
        Auth::loginUsingId($user->id, false);
        return \Redirect::route('home');
    }
}
