<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\User;
use App\Group;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActionsController extends Controller
{
    public function index()
    {
        $source = new Action;

        $filter = \DataFilter::source($source);
        $filter->add('name','Název', 'text');
        $filter->add('year','Rok', 'text');
        $filter->add('active','Aktivní','select')->options(array_merge(["" => "-- Aktivní --"],\App\Action::booleanValue));
        $filter->add('public','Veřejná','select')->options(array_merge(["" => "-- Veřejná --"],\App\Action::booleanValue));
        $filter->submit('Vybrat');
        $filter->reset('Reset');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('id','ID', true);
        $grid->add('name','Název',true);
        $grid->add('year','Rok',true);
        $grid->add('{{ \App\Action::booleanValue[$active] }}','Aktivní');
        $grid->add('{{ \App\Action::booleanValue[$public] }}','Veřejná');
        $grid->add('<a class="btn btn-secondary btn-sm" href="{{ url("actions/$id") }}">Detail</a>','Akce');
        $grid->link('/actions/create',"Nový", "TR");
        $grid->orderBy('name','asc');
        $grid->paginate(30);

        return view('actions.index', compact('grid',"filter"));
    }

    public function show(Action $action)
    {
        $author = \App\User::find($action->users_id);
        $groups = \App\Group::leftJoin("applications","applications.groups_id","=","groups.id")
            ->select("groups.id","groups.name","groups.capacity","groups.open", DB::raw("count(applications.created_at) AS count"))
            ->groupBy("groups.id")
            ->groupBy("groups.name")
            ->groupBy("groups.capacity")
            ->groupBy("groups.open")
            ->where("actions_id","=",$action->id)
            ->whereNull("applications.cancelled_at")
            ->get();
        return view('actions.show',["action" => $action,"groups" => $groups,"user" => $author]);
    }

    public function create()
    {
        return view('actions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|max:255",
            "year" => "required|int|min:2016|max:2020",
            "start" => "required",
            "end" => "required",
        ]);

        try 
        {
            $action = Action::create([
                "name" => $request->name,
                "year" => $request->year,
                "start" => Carbon::createFromFormat('Y-m-d\TH:i', $request->start)->toDateTimeString(),
                "end" => Carbon::createFromFormat('Y-m-d\TH:i', $request->end)->toDateTimeString(),
                "description" => $request->description,
                "users_id" => Auth::user()->id,
                "active" => (bool)(request("active","0")),
                "public" => (bool)(request("public","0")),
            ]);
            flash("Akce byla přidána.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při přidávání akce došlo k chybě.")->danger();
        }

        return \Redirect::route('actions');
    }

    public function edit(Action $action)
    {
        return view('actions.edit',["action" => $action]);
    }

    public function patch(Action $action, Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|max:255",
            "year" => "required|int|min:2016|max:2020",
            "start" => "required",
            "end" => "required",
        ]);

        try 
        {
            $action->update([
                "name" => $request->name,
                "year" => $request->year,
                "start" => Carbon::createFromFormat('Y-m-d\TH:i', $request->start)->toDateTimeString(),
                "end" => Carbon::createFromFormat('Y-m-d\TH:i', $request->end)->toDateTimeString(),
                "description" => $request->description,
                "users_id" => Auth::user()->id,
                "active" => (bool)(request("active","0")),
                "public" => (bool)(request("public","0")),
            ]);
            flash("Akce byla uložena.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při ukládání akce došlo k chybě.")->danger();
        }

        return \Redirect::route('actions.show',$action->id);
    }

    public function destroy(Action $action)
    {
        try
        {
            $action->delete();
            flash("Akce byla smazána.")->success();
        }
        catch (Exception $ex)
        {
            flash("Odstranění akce se nepodařilo.")->danger();
        }
        return \Redirect::route('actions');
    }

    public function activate(Action $action)
    {
        $action->active = 1;
        $action->save();
        flash("Akce je nyní aktivní.")->success();
        return \Redirect::back();
    }

    public function deactivate(Action $action)
    {
        $action->active = 0;
        $action->save();
        flash("Akce je nyní neaktivní.")->success();
        return \Redirect::back();
    }

    public function publish(Action $action)
    {
        $action->public = 1;
        $action->save();
        flash("Akce je nyní viditelná na titulní stránce.")->success();
        return \Redirect::back();
    }

    public function hide(Action $action)
    {
        $action->public = 0;
        $action->save();
        flash("Akce je nyní skrytá z hlavní stránky.")->success();
        return \Redirect::back();
    }

    public function open(Action $action)
    {
        $action->groups()->update(["open" => 1]);
        flash("Skupiny v akci jsou nyní otevřené.")->success();
        return \Redirect::back();
    }

    public function close(Action $action)
    {
        $action->groups()->update(["open" => 0]);
        flash("Skupiny v akci jsou nyní uzavřené.")->success();
        return \Redirect::back();
    }
}
