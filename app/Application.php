<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Action;

class Application extends Model
{
    const CREATION_OK = 0;
    const ALREADY_EXISTS = 1;
    const IN_ANOTHER_GROUP = 2;
    const OUT_OF_CAPACITY = 3;
    const ACTION_NOT_PUBLIC = 4;
    const INSUFFICIENT_AGE = 5;

    protected $table = 'applications';

    protected $fillable = [
        'users_id', 'groups_id', "created_by", "cancelled_by", "cancelled_at"
    ];
    protected $dates = ["cancelled_at","created_at","updated_at"];

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Group', 'groups_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo('App\User', 'cancelled_by');
    }  

    public static function validateExistence($userId, $groupId, $checkPublic = false)
    {
        $group = \App\Group::find($groupId);
        $action = \App\Action::find($group->actions_id);
        $previous = self::where(["users_id" => $userId, "groups_id" => $groupId, "cancelled_by" => null])->get();
        if ($checkPublic && $action->public == false) return self::ACTION_NOT_PUBLIC;
        if ($previous->isNotEmpty()) return self::ALREADY_EXISTS;
        if ($group->minimal_year && Auth::user()->year && ($group->minimal_year > Auth::user()->year)) return self::INSUFFICIENT_AGE;
        $concurrentGroups = $group->action->groups;
        $groups = [];
        foreach($concurrentGroups as $g) {$groups[] = $g->id;};
        $concurrent = self::where(["users_id" => $userId, "cancelled_by" => null])->whereIn("groups_id",$groups)->get(); 
        if ($concurrent->isNotEmpty()) return self::IN_ANOTHER_GROUP;
        $valid = self::where(["groups_id" => $groupId, "cancelled_by" => null])->count();
        if ($valid >= $group->capacity) return self::OUT_OF_CAPACITY;
        return self::CREATION_OK;
    }

    public static function getUserApplicationInAction($actionId,$userId)
    {
        return DB::select('select * from applications 
            join groups on applications.groups_id = groups.id
            WHERE groups.actions_id = ? AND applications.users_id = ? AND cancelled_at IS NULL 
            ', [$actionId,$userId]);
    }
}
