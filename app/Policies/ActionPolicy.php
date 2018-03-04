<?php

namespace App\Policies;

use App\User;
use App\Action;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function view(User $user, Action $action)
    {
        return ($user->isAdministrator());
    }

    public function viewList(User $user)
    {
        return ($user->isAdministrator());
    }

    /**
     * Determine whether the user can create actions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->isAdministrator());
    }

    /**
     * Determine whether the user can update the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function update(User $user, Action $action)
    {
        return ($user->isAdministrator());
    }

    /**
     * Determine whether the user can delete the action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function delete(User $user, Action $action)
    {
        return ($user->isAdministrator());
    }

    /**
     * Determine whether the user can activate action.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function activate(User $user, Action $action)
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can open groups within this action to public.
     *
     * @param  \App\User  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function open(User $user, Action $action)
    {
        return $user->isAdministrator();
    }
}
