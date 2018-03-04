<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Application;
//use Zofe\Rapyd\DataGrid;

class UsersController extends Controller
{
    public function index()
    {
        $source = new User;

        $filter = \DataFilter::source($source);
        $filter->add('firstname','Jméno', 'text');
        $filter->add('lastname','Příjmení', 'text');
        $filter->add('role','Role','select')->options(array_merge(["" => "-- Role --"],\App\User::roleValue));
        $filter->add('active','Aktivní','select')->options(array_merge(["" => "-- Aktivní --"],\App\User::booleanValue));
        $filter->add('email','Email','text');
        $filter->add('school','Škola','text');
        $filter->add('year','Ročník','text');
        $filter->add('potential_student','Zájemce','select')->options(array_merge(["" => "-- Zájemce --"],\App\User::booleanValue));
        $filter->submit('Vybrat');
        $filter->reset('Reset');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('id','ID', true);
        $grid->add('firstname','Jméno',true);
        $grid->add('lastname','Příjmení',true);
        $grid->add('{{ \App\User::genderValue[$gender] }}','Pohlaví');
        $grid->add('{{ \App\User::roleValue[$role] }}','Role');
        $grid->add('{{ \App\User::booleanValue[$active] }}','Aktivní');
        $grid->add('{{ \App\User::booleanValue[$banned] }}','Zablokovaný');
        $grid->add('email','Email',true);
        $grid->add('school','Škola',true);
        $grid->add('year','Ročník',true);
        $grid->add('{{ \App\User::booleanValue[$potential_student] }}','Zájemce o studium');
        $grid->add('<a class="btn btn-secondary btn-sm" href="{{ url("users/$id") }}">Detail</a>','Akce');
        $grid->link('/users/create',"Nový", "TR");
        $grid->orderBy('lastname','asc');
        $grid->paginate(30);

        return view('users.index', compact('grid',"filter"));
    }

    public function show(User $user)
    {
        $applications = \App\Application::where(["users_id" => $user->id])->get();
        return view('users.show',["user" => $user, "applications" => $applications]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "birthdate" => "required",
            "gender" => "required",
            "email" => "required|email|unique:users",
            "role" => "required",
        ]);

        $password = str_random(20);

        try 
        {
            $user = User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "birthdate" => $request->birthdate,
                "gender" => $request->gender,
                "email" => $request->email,
                "school" => $request->school,
                "year" => $request->year,
                "role" => $request->role,
                "keep_informed" => (bool)(request("keep_informed","0")),
                "potential_student" => (bool)(request("potential_student","0")),
                "email_confirmed" => (bool)(request("email_confirmed","0")),
                "active" => (bool)(request("active","0")),
                "banned" => (bool)(request("banned","0")),
                "password" => bcrypt($password),
            ]);
            flash("Uživatel byl přidán.")->success();
            flash("Uživatel má vygenerované heslo " . $password)->info();
        }
        catch (Exception $ex)
        {
            flash("Při přidávání uživatele došlo k chybě.")->danger();
        }

        return \Redirect::route('users');
    }

    public function edit(User $user)
    {
        return view('users.edit',["user" => $user]);
    }

    public function patch(User $user)
    {
        $this->validate(request(),[
            "firstname" => "required|string|max:255",
            "lastname" => "required|string|max:255",
            "birthdate" => "required",
            "gender" => "required",
            "email" => "required|email|unique:users,email,".$user->id,
            "role" => "required",
        ]);        

        try {
            $user->update([
                    "firstname" => request("firstname"),
                    "lastname" => request("lastname"),
                    "birthdate" => request("birthdate"),
                    "gender" => request("gender"),
                    "email" => request("email"),
                    "school" => request("school"),
                    "year" => request("year"),
                    "role" => request("role"),
                    "fb_id" => request("fb_id",null),
                    "keep_informed" => (bool)(request("keep_informed","0")),
                    "potential_student" => (bool)(request("potential_student","0")),
                    "email_confirmed" => (bool)(request("email_confirmed","0")),
                    "active" => (bool)(request("active","0")),
                    "banned" => (bool)(request("banned","0")),            
            ]);
            $user->save();
            flash("Uživatel byl uložen úspěšně.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při ukládání uživatele došlo k chybě.")->danger();
        }
        return \Redirect::route('users.show',$user->id);
    }

    public function destroy(User $user)
    {
        try
        {
            $user->delete();
            flash("Uživatel byl smazán.")->success();
        }
        catch (Exception $ex)
        {
            flash("Odstranění uživatele se nepodařilo.")->danger();
        }
        return \Redirect::back();
    }

    public function ban(User $user)
    {
        $user->banned = 1;
        $user->save();
        flash("Uživatel byl zablokován.")->success();
        return \Redirect::back();
    }

    public function unban(User $user)
    {
        $user->banned = 0;
        $user->save();
        flash("Uživatel byl odblokován.")->success();
        return \Redirect::back();
    }

    public function password(User $user)
    {
        return view('users.password',["user" => $user]);
    }

    public function storePassword(User $user)
    {
        $this->validate(request(),[
            "password" => "required|string",
        ]);

        try {
            $user->update([
                    "password" => bcrypt(request("password")),           
            ]);
            $user->save();
            flash("Heslo bylo nastaveno.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při ukládání hesla došlo k chybě.")->danger();
        }
        return \Redirect::route('users.show',$user->id);                
    }
}
