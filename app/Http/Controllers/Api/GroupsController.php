<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::all("id","name","actions_id");
        return $groups;
    }

    public function show(Group $group)
    {
        $result = new \stdClass;
        $result->name = $group->name;
        $result->description = $group->description;
        $result->capacity = $group->capacity;
        $result->minimal_year = $group->minimal_year;
        $result->lectorFirstname = $group->user->firstname;
        $result->lectorLastname = $group->user->lastname;
        $result->applications = $group->applications->where("cancelled_by", null)->count();
        return response()->json($result);
    }
}
