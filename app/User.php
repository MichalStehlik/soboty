<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'gender', 'birthdate', 'school', 'year', 'email', 
        'password', 'potential_student', 'keep_informed', 'confirmation_code', "confirmation_validity","role","email_confirmed",
        "fb_id"
    ];
    protected $dates = ["confirmation_validity","created_at","updated_at"];

    const genderValue = ["male" => "Muž", "female" => "Žena"];
    const roleValue = ["user" => "Uživatel", "lector" => "Lektor", "administrator" => "Administrátor"];
    const booleanValue = ["Ne","Ano"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation_code',
    ];

    public function isAdministrator()
    {
        return ($this->role === "administrator");
    }

    public function isLector()
    {
        return ($this->role === "lector");
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAdministrator($query)
    {
        return $query->where('role', "administrator");
    }

    public function scopeLector($query)
    {
        return $query->where('role', "lector");
    }

    public function scopeLectorOrAdministrator($query)
    {
        return $query->where('role', "lector")->orWhere('role', "administrator");
    }

    public function getFullnameAttribute($value)
    {
        return $this->firstname ." ". $this->lastname;
    }
}
