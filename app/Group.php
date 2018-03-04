<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name', "open", "actions_id", "users_id", "description", "capacity","minimal_year"
    ];
    protected $dates = ["created_at","updated_at"];

    const booleanValue = ["Ne","Ano"];

    public function action()
    {
        return $this->belongsTo('App\Action', 'actions_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function applications()
    {
        return $this->hasMany('App\Application',"groups_id");
    }

    public function scopeOpen($query)
    {
        return $query->where('open', 1);
    }

    public function scopeClosed($query)
    {
        return $query->where('open', 0);
    }

    public static function getOpenGroupsInAction($actionId)
    {
        return DB::select('select groups.id,name,description,capacity,open,count(a.id) as applications FROM groups 
            left join 
            (select * from applications where cancelled_at is null) as a on a.groups_id = groups.id 
            where open = 1 and actions_id = ?
            group by groups.id,groups.name,description,capacity,open', [$actionId]);
    }

    public static function getGroupsInAction($actionId)
    {
        return DB::select('select groups.id,name,description,capacity,open,count(a.id) as applications FROM groups 
            left join 
            (select * from applications where cancelled_at is null) as a on a.groups_id = groups.id 
            where actions_id = ?
            group by groups.id,groups.name,description,capacity,open', [$actionId]);
    }
}
