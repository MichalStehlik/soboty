<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\EmailConfirmation;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function create()
    {
        return view("registration.register");
    }

    public function store()
    {
        $this->validate(request(),[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "birthdate" => "required",
            "gender" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6|confirmed",
        ]);

        $confirmationCode = str_random(20);
        $email = request("email");

        $user = User::create([
            "firstname" => request("firstname"),
            "lastname" => request("lastname"),
            "birthdate" => request("birthdate"),
            "gender" => request("gender"),
            "email" => $email,
            "school" => request("school"),
            "year" => request("year"),
            "password" => bcrypt(request("password")),
            "keep_informed" => (bool)(request("keep_informed","0")),
            "potential_student" => (bool)(request("potential_student","0")),
            "confirmation_code" => $confirmationCode,
            "confirmation_expiration" => (Carbon::now()->addHour()->format('Y-m-d H:i:s')),
        ]);
        flash("Na Vámi uvedenou adresu byl zaslán email s potvrzovacím kódem.");
        \Mail::to($user)->send(new EmailConfirmation($user));

        return \Redirect::route('verify', ["email" => $email]);
    }

    public function verify()
    {
        return view("registration.verify",["email" => request("email"),"code" => request("code")]);
    }

    public function confirm()
    {
        $this->validate(request(),[
            "email" => "required|email|exists:users,email",
            "code" => "required"
        ]);

        $user = User::whereEmail(request("email"))->first();
        $now = Carbon::now();
        $validity = Carbon::parse($user->confirmation_expiration);
        if ($user)
        {
            if ($user->confirmation_code != request("code"))
            {
                return \Redirect::back()->withErrors(["code" => "Zadaný kód není platný."])->withInput();
            }
            else if ($now->gt($validity))
            {
                return \Redirect::back()->withErrors(["code" => "Platnost tohoto kódu již vypršela."])->withInput();
            }
            else
            {
                flash("Vítejte. Vaše registrace byla úspěšná.")->success();
                $user->email_confirmed = 1;
                $user->confirmation_expiration = null;
                $user->confirmation_code = null;
                $user->save();
                \Auth::login($user);
                return \Redirect::route('home');
            }
        }
        else
        {
            return \Redirect::back()->withErrors(["email" => "Neznámý email"])->withInput();
        }
    }

    public function retry($email)
    {
        $user = User::whereEmail($email)->first();
        if ($user)
        {
            $confirmationCode = str_random(20);
            $email = $user->email;
            $user->confirmation_code = $confirmationCode;
            $user->save();
            flash("Na Vámi uvedenou adresu byl zaslán nový email s potvrzovacím kódem.");
            \Mail::to($user)->send(new EmailConfirmation($user));
            return \Redirect::route('verify', ["email" => $email]);
        }
        else
        {
            return \Redirect::route('verify', ["email" => $email])->withErrors(["email" => "Neznámý email"])->withInput();
        }
    }
}
