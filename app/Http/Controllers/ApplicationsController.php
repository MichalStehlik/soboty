<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\User;
use App\Application;
use App\Group;
use Auth;
use Carbon\Carbon;

class ApplicationsController extends Controller
{
    public function index()
    {
        $source = Application::with('user',"group","createdBy","cancelledBy");
        $groups = [];
        $groupData = \App\Group::orderBy("id")->get();
        foreach ($groupData as $g) {$groups[$g->id] = $g->action->year . " \ " . $g->action->name . " \ " . $g->name;}

        $filter = \DataFilter::source($source);
        $filter->add('user.lastname','Příjmení', 'text');
        $filter->add('groups_id','Skupina','select')->options(["" => "-- Skupina --"] + $groups);
        $filter->submit('Vybrat');
        $filter->reset('Reset');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('id','ID');
        $grid->add('user.firstname','Jméno');
        $grid->add('user.lastname','Příjmení');
        $grid->add('group.action.year','Rok');
        $grid->add('group.action.name','Akce');
        $grid->add('group.name','Skupina');       
        $grid->add('created_at','Vytvořeno',true);
        $grid->add('createdBy.fullname','Vytvořil');
        $grid->add('cancelled_at','Zrušeno',true);
        $grid->add('cancelledBy.fullname','Zrušil');
        $grid->add('<a class="btn btn-primary btn-sm" href="{{ url("applications/$id") }}">Detail</a>','Akce');
        $grid->link('/applications/create',"Nová", "TR");
        $grid->orderBy('groups_id','asc');
        $grid->paginate(30);

        return view('applications.index', compact('grid',"filter"));
    }

    public function show(Application $application)
    {
        $user = \App\User::find($application->users_id);
        $group = \App\Group::find($application->groups_id);
        $created = \App\User::find($application->created_by);
        $cancelled = \App\User::find($application->cancelled_by);
        return view('applications.show',["application" => $application,"group" => $group,"created" => $created,"cancelled" => $cancelled, "user" => $user]);
    }

    public function create()
    {
        $groups = \App\Group::open()->orderBy("name")->get();
        $users = \App\User::active()->orderBy("lastname")->get();
        return view('applications.create',["groups" => $groups,"users" => $users]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "user" => "required|exists:users,id",
            "group" => "required|exists:groups,id",
        ]);
        
        $valid = Application::validateExistence($request["user"],$request["group"]);
        if ($valid == Application::CREATION_OK || ($valid == Application::OUT_OF_CAPACITY && $request->overCapacityAllowed))
        {
            try 
            {
                $application = Application::create([
                    "users_id" => $request->user,
                    "groups_id" => $request->group,
                    "created_by" => Auth::user()->id,
                ]);
                flash("Záznam byl přidán.")->success();
            }
            catch (Exception $ex)
            {
                flash("Při přidávání záznamu došlo k chybě.")->error();
            }
        }
        else
        {
            if ($valid == Application::ALREADY_EXISTS) flash("Přihláška již existuje.")->error();
            else if ($valid == Application::ACTION_NOT_PUBLIC) flash("Skupina patří do akce, která nyní není přístupná pro veřejnost.")->error();
            else if ($valid == Application::IN_ANOTHER_GROUP) flash("Uživatel je přihlášen v jiné souběžné skupině.")->error();
            else if ($valid == Application::OUT_OF_CAPACITY) flash("Ve skupině již není místo.")->error();
            else flash("Přihláška nebyla vytvořena.")->error();
        }

        return \Redirect::route('applications');
    }

    public function destroy(Application $application)
    {
        try
        {
            $application->delete();
            flash("Přihláška byla smazána.")->success();
        }
        catch (Exception $ex)
        {
            flash("Odstranění přihlášky se nepodařilo.")->error();
        }
        return \Redirect::route('applications');
    }

    public function cancel(Application $application)
    {
        $application->cancelled_by = Auth::user()->id;
        $application->cancelled_at = Carbon::now();
        $application->save();
        flash("Přihláška je zrušena.")->success();
        return \Redirect::back();
    }
}
