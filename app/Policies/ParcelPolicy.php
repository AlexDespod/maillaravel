<?php

namespace App\Policies;

use App\Models\BankModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParcelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // dd($user->roles[0]->slug);
        return $user->hasRole(['admin', 'sender']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankModel  $bankModel
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasRole(['admin', 'sender']);

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(['sender', 'admin', 'guest']);

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankModel  $bankModel
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole(['sender', 'admin']);

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankModel  $bankModel
     * @return mixed
     */
    public function delete(User $user, BankModel $bankModel)
    {
        return $user->hasRole(['sender', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankModel  $bankModel
     * @return mixed
     */
    public function restore(User $user, BankModel $bankModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankModel  $bankModel
     * @return mixed
     */
    public function forceDelete(User $user, BankModel $bankModel)
    {
        //
    }
}
