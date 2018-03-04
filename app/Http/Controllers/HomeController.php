<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Action;
use App\Group;
use App\Application;
use Auth;
use Carbon\Carbon;
use App\Mail\ApplicationCreated;

class HomeController extends Controller
{
    public function index()
    {
        $activeActions = Action::isPublic()->get();
        $groupsInAction = [];
        $applicationsInAction = [];
        $userApplications = [];
        if (Auth::check())
        {
            $userApplications = Application::where(["users_id" => Auth::user()->id])->orderBy('created_at', 'DESC')->take(3)->get();
        }
        foreach ($activeActions as $a)
        {
            $groupsInAction[$a->id] = Group::getGroupsInAction($a->id);
            if (Auth::check())
            $applicationsInAction[$a->id] = Application::getUserApplicationInAction($a->id,Auth::user()->id);
            else
            $applicationsInAction[$a->id] = [];
        }
        return view('home.index',["actions" => $activeActions, "groups" => $groupsInAction, "applications" => $applicationsInAction,"userApplications" => $userApplications]);
    }

    public function sign(Group $group)
    {
        if (($valid = Application::validateExistence(Auth::user()->id,$group->id, true)) == Application::CREATION_OK)
        {
            try 
            {
                $application = Application::create([
                    "users_id" => Auth::user()->id,
                    "groups_id" => $group->id,
                    "created_by" => Auth::user()->id,
                ]);
                \Mail::to(Auth::user())->send(new ApplicationCreated($application)); 
                flash("Přihláška byla vytvořena.")->success();
            }
            catch (Exception $ex)
            {
                flash("Při přidávání záznamu došlo k chybě.")->error();
            }
        }
        else
        {
            if ($valid == Application::ALREADY_EXISTS) flash("Taková přihláška již existovala.")->error();
            else if ($valid == Application::ACTION_NOT_PUBLIC) flash("Akce přiřazená k této skupině není přístupná pro veřejnost.")->error();
            else if ($valid == Application::IN_ANOTHER_GROUP) flash("Již jste přihlášen v jiné souběžné skupině.")->error();
            else if ($valid == Application::OUT_OF_CAPACITY) flash("Ve skupině již není místo. Někdo Vás asi předběhl.")->error();
            else if ($valid == Application::INSUFFICIENT_AGE) flash("Pro zápis do skupiny je nastavené omezení na minimální ročník nebo věk účastníka. Tuto podmínku nespňujete.")->error();
            else flash("Přihláška nebyla vytvořena.")->error();
        }

        return \Redirect::route('home');
    }

    public function leave(Group $group)
    {
        $applications = Application::where(["users_id" => Auth::user()->id,"groups_id" => $group->id ,"cancelled_at" => null]);
        if ($applications)
        {
            $applications->update(["cancelled_by" => Auth::user()->id, "cancelled_at" => Carbon::now()]);
            flash("Přihláška byla zrušena.")->success();
        }
        else
        {
            flash("Taková přihláška neexistuje.")->error();
        }
        return \Redirect::route('home');
    }
}
