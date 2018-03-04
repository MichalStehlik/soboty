<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';

    protected $fillable = [
        'name', 'year', "start", "end", "users_id", "description","active","public"
    ];
    protected $dates = ["start","end","created_at","updated_at"];

    const booleanValue = ["Ne","Ano"];

    public function groups()
    {
        return $this->hasMany('App\Group',"actions_id");
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeIsPublic($query)
    {
        return $query->where('public', 1);
    }
}
