<?php

namespace App\Policies;

use App\User;
use App\Group;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    public function viewList(User $user)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $mroup
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can open or close the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function open(User $user, Group $group)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can leave the Application.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function leave(User $user, Group $group)
    {
        $applications = Application::where(["users_id" => Auth::user()->id,"groups_id" => $group->id ,"cancelled_at" => null])->get();
        if ($applications) return true; else return false;
    }

    /**
     * Determine whether the user can print certificates for this group
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function certificates(User $user, Group $group)
    {
        return ($user->isAdministrator() || $user->isLector());
    }
}
