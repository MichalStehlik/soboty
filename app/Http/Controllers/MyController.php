<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Application;
use Auth;
use Carbon\Carbon;

class MyController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('my.index',["user" => $user]);
    }

    public function applications()
    {
        $applications = Application::where(["users_id" => Auth::user()->id])->orderBy('created_at', 'DESC')->get();
        return view('my.applications',["applications" => $applications]);
    }

    public function edit()
    {
        $user = User::find(Auth::user()->id);
        return view('my.edit',["user" => $user]);
    }

    public function patch()
    {
        $this->validate(request(),[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "birthdate" => "required",
            "gender" => "required",
        ]);        

        try {
            $user = User::find(Auth::user()->id);
            if ($user)
            {
                $user->update([
                    "firstname" => request("firstname"),
                    "lastname" => request("lastname"),
                    "birthdate" => request("birthdate"),
                    "gender" => request("gender"),
                    "school" => request("school"),
                    "year" => request("year"),
                    "keep_informed" => (bool)(request("keep_informed","0")),
                    "potential_student" => (bool)(request("potential_student","0")),          
                ]);
                $user->save();
                flash("Uživatel byl uložen úspěšně.")->success();
            }
            else
            {
                flash("Při ukládání uživatele došlo k chybě. Bylo požádáno o editaci neexistujícího uživatele.")->danger();
            }
        }
        catch (Exception $ex)
        {
            flash("Při ukládání uživatele došlo k chybě.")->danger();
        }
        return \Redirect::route('personal.profile');
    }
}
