<?php

namespace App\Policies;

use App\User;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if (Auth::guest()) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the Application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function viewList(User $user)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can view the Application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can create Applications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Application.
     *
     * @param  \App\User  $user
     * @param  \App\=Application  $Application
     * @return mixed
     */
    public function update(User $user, Application $application)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can delete the Application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        return ($user->isAdministrator() || $user->isLector());
    }

    /**
     * Determine whether the user can cancel the Application.
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     * @return mixed
     */
    public function cancel(User $user, Application $application)
    {
        return ($user->isAdministrator() || $user->isLector() || ($user == $application->users_id));
    }
}

