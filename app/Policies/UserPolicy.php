<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the users.
     *
     * @param  \App\User  $currentUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $currentUser, User $user)
    {
        return ($currentUser->is($user)) || ($currentUser->isAdministrator());
    }

    public function viewList(User $currentUser)
    {
        return ($currentUser->isAdministrator());
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $currentUser)
    {
        return true;
    }

    /**
     * Determine whether the user can update the users.
     *
     * @param  \App\User  $user
     * @param  \App\Users  $users
     * @return mixed
     */
    public function update(User $currentUser, User $user)
    {
        return ($currentUser->is($user)) || ($currentUser->isAdministrator());
    }

    /**
     * Determine whether the user can delete the users.
     *
     * @param  \App\User  $user
     * @param  \App\Users  $users
     * @return mixed
     */
    public function delete(User $currentUser, User $user)
    {
        return ($currentUser->isAdministrator());
    }

    /**
     * Determine whether the user can ban the users.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function ban(User $currentUser, User $user)
    {
        return $currentUser->isAdministrator();
    }
}
