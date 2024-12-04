<?php

namespace App\Policies;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatePolicy
{
    use HandlesAuthorization;
	
	public function before(User $user)
	{
		if ($user->isAdmin()) {
			return true;
		}
	}
	
	 /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('viewany.rate');
    }

    /**
     * Determine whether the user can view the DocRate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rate  $rate
     * @return bool
     */
    public function view(User $user, Rate $rate): bool
    {
		return $user->hasPermission('view.rate');
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
		return $user->hasPermission('create.rate');
    }

    /**
     * Determine whether the user can update the DocRate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rate  $rate
     * @return bool
     */
    public function update(User $user, Rate $rate): bool
    {
        return $user->hasPermission('update.rate') || $user->id == $rate->user_id;
    }

    /**
     * Determine whether the user can delete the DocRate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rate  $rate
     * @return bool
     */
    public function delete(User $user, Rate $rate): bool
    {
        return  $user->hasPermission('delete.rate') || $user->id == $rate->user_id;
    }

    /**
     * Determine whether the user can restore the DocRate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rate  $rate
     * @return bool
     */
    public function restore(User $user, Rate $rate): bool
    {
         return $user->hasPermission('restore.rate') || $user->id == $rate->user_id;
    }

    /**
     * Determine whether the user can permanently delete the DocRate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rate  $rate
     * @return bool
     */
    public function forceDelete(User $user, Rate $rate): bool
    {
        return $user->hasPermission('forcedelete.rate') || $user->id == $rate->user_id;		
    }
}