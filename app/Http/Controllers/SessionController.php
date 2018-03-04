<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\PasswordRecovery;
use App\User;

class SessionController extends Controller
{
    public function create()
    {
        return view("session.login");
    }

    public function destroy()
    {
        auth()->logout();
        return redirect()->home();
    }

    public function store()
    {
        $this->validate(request(),[
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);

        if (Auth::attempt(['email' => request("email"), 'password' => request("password"), "banned" => 0], request("remember")))
        {
            $user = User::whereEmail(request("email"))->first();
            $user->active = 1;
            $user->save();
            return redirect()->intended('');
        }
        else
        {
            return \Redirect::back()->withErrors(["password" => "Nesprávné heslo."])->withInput();
        }
    }

    public function request()
    {
        return view("session.request");
    }

    public function generateToken()
    {
        $this->validate(request(),[
            "email" => "required|email|exists:users,email",
        ]);

        $requestToken = str_random(30);
        $expiration = (Carbon::now()->addHour()->format('Y-m-d H:i:s'));
        $user = User::whereEmail(request("email"))->first();
        $user->request_token = $requestToken;
        $user->request_expiration = $expiration;
        $user->save();
        flash("Na Vámi uvedenou adresu byl zaslán email s potvrzovacím kódem.");
        \Mail::to($user)->send(new PasswordRecovery($user)); 
        return \Redirect::route('password.set', ["email" => $user->email]);     
    }

    public function password()
    {
        return view("session.password",["email" => request("email"),"code" => request("code")]);
    }

    public function setPassword()
    {
        $this->validate(request(),[
            "email" => "required|email|exists:users,email",
            "code" => "required",
            "password" => "required|string|min:6|confirmed",
        ]);

        $user = User::whereEmail(request("email"))->first();
        $now = Carbon::now();
        $validity = Carbon::parse($user->request_expiration);

        if ($user)
        {
            if ($user->request_token != request("code"))
            {
                return \Redirect::back()->withErrors(["code" => "Zadaný token není platný."])->withInput();
            }
            else if ($now->gt($validity))
            {
                return \Redirect::back()->withErrors(["code" => "Platnost tohoto tokenu již vypršela."])->withInput();
            }
            else
            {
                flash("Heslo bylo nastaveno. Nyní jej můžete použít pro přihlášení.")->success();
                $user->password = bcrypt(request("password"));
                $user->request_expiration = null;
                $user->request_token = null;
                $user->save();
                return \Redirect::route('home');
            }
        }
        else
        {
            return \Redirect::back()->withErrors(["email" => "Neznámý email"])->withInput();
        }
    }
}
