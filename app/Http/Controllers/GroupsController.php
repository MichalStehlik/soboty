<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\User;
use App\Group;
use Auth;
use Carbon\Carbon;
use PDF;

class GroupsController extends Controller
{
    public function index()
    {
        $source = Group::with('action')->with("applications");
        $actions = [];
        $actionData = \App\Action::orderBy("year","name")->get();
        foreach ($actionData as $a) {$actions[$a->id]=$a->year." \ ".$a->name;}

        $filter = \DataFilter::source($source);
        $filter->add('name','Název', 'text');
        $filter->add('actions_id','Akce','select')->options(["" => "-- Akce --"] + $actions);
        $filter->add('open','Otevřená','select')->options(array_merge(["" => "-- Otevřená --"],\App\Group::booleanValue));
        $filter->submit('Vybrat');
        $filter->reset('Reset');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('id','ID', true);
        $grid->add('name','Název',true);
        $grid->add('action.name','Akce',true);
        $grid->add('capacity','Kapacita',true);
        //$grid->add("{{ $capacity }}",'Počet přihlášek',true);
        $grid->add('{{ \App\Action::booleanValue[$open] }}','Otevřená');
        $grid->add('<a class="btn btn-secondary btn-sm" href="{{ url("groups/$id") }}">Detail</a>','Akce');
        $grid->link('/groups/create',"Nový", "TR");
        $grid->orderBy('name','asc');
        $grid->paginate(30);

        return view('groups.index', compact('grid',"filter"));
    }

    public function show(Group $group)
    {
        $lector = \App\User::find($group->users_id);
        $action = \App\Action::find($group->actions_id);
        $applications = \App\Application::where(["groups_id" => $group->id, "cancelled_by" => null])->get();
        return view('groups.show',["group" => $group,"action" => $action,"user" => $lector,"applications" => $applications]);
    }

    public function create()
    {
        $actions = \App\Action::active()->get();
        $lectors = \App\User::active()->lectorOrAdministrator()->orderBy("lastname")->get();
        $targetAction = request("action",false);
        return view('groups.create',["lectors" => $lectors,"actions" => $actions,"targetAction" => $targetAction]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|max:255",
            "lector" => "required|exists:users,id",
            "action" => "required|exists:actions,id",
            "capacity" => "required|int|min:0|max:100",
            "description" => "required",
        ]);

        try 
        {
            $group = Group::create([
                "name" => $request->name,
                "users_id" => $request->lector,
                "actions_id" => $request->action,
                "description" => $request->description,
                "capacity" => $request->capacity,
                "minimal_year" => $request->minimal_year,
                "open" => (bool)(request("open","0")),
            ]);
            flash("Skupina byla přidána.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při přidávání skupiny došlo k chybě.")->danger();
        }

        return \Redirect::route('groups');
    }

    public function edit(Group $group)
    {
        $actions = \App\Action::active()->get();
        $lectors = \App\User::active()->lectorOrAdministrator()->orderBy("lastname")->get();        
        return view('groups.edit',["group" => $group,"lectors" => $lectors,"actions" => $actions]);
    }

    public function patch(Group $group, Request $request)
    {
        $this->validate($request,[
            "name" => "required|string|max:255",
            "lector" => "required|exists:users,id",
            "action" => "required|exists:actions,id",
            "capacity" => "required|int|min:0|max:100",
            "description" => "required",
        ]);

        try 
        {
            $group->update([
                "name" => $request->name,
                "users_id" => $request->lector,
                "actions_id" => $request->action,
                "description" => $request->description,
                "capacity" => $request->capacity,
                "minimal_year" => $request->minimal_year,
                "open" => (bool)(request("open","0")),
            ]);
            flash("Skupina byla uložena.")->success();
        }
        catch (Exception $ex)
        {
            flash("Při ukládání skupiny došlo k chybě.")->danger();
        }

        return \Redirect::route('groups.show',$group->id);
    }

    public function destroy(Group $group)
    {
        try
        {
            $group->delete();
            flash("Skupina byla smazána.")->success();
        }
        catch (Exception $ex)
        {
            flash("Odstranění skupiny se nepodařilo.")->danger();
        }
        return \Redirect::route('groups');
    }

    public function open(Group $group)
    {
        $group->open = 1;
        $group->save();
        flash("Skupina je nyní otevřená.")->success();
        return \Redirect::back();
    }

    public function close(Group $group)
    {
        $group->open = 0;
        $group->save();
        flash("Skupina je nyní uzavřená.")->success();
        return \Redirect::back();
    }

    public function certificates(Group $group)
    {
        $mytime = Carbon::now();
        $filename = $mytime->toDateTimeString() . "_" . $group->name . "_certificates.pdf";
        $applications = \App\Application::where(["groups_id" => $group->id, "cancelled_by" => null])->get();
        $pdf = PDF::loadView('pdf.certificate', ["group" => $group,"applications" => $applications, "today" => $mytime],[],[
            'title' => 'Osvědčení o účasti',
            'format' => "A4-L",
            "dpi" => 300,
            "image_dpi" => 300
        ]);
        return $pdf->stream($filename);
    }

    public function participants(Group $group)
    {
        $mytime = Carbon::now();
        $filename = $mytime->toDateTimeString() . "_" . $group->name . "_list.pdf";
        $applications = \App\Application::where(["groups_id" => $group->id, "cancelled_by" => null])
            ->join('users', 'users.id', '=', 'applications.users_id')
            ->orderBy("users.lastname","asc")->get();
        $pdf = PDF::loadView('pdf.list', ["group" => $group,"applications" => $applications, "today" => $mytime],[],[
            'title' => 'Seznam účastníků',
            'format' => "A4",
            "dpi" => 300,
            "image_dpi" => 300
        ]);
        return $pdf->stream($filename);        
    }
}
