<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
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
        return $user->hasPermission('viewany.setting');
    }

    /**
     * Determine whether the user can view the DocSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return bool
     */
    public function view(User $user, Setting $setting): bool
    {
		return $user->hasPermission('view.setting');
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
		return $user->hasPermission('create.setting');
    }

    /**
     * Determine whether the user can update the DocSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return bool
     */
    public function update(User $user, Setting $setting): bool
    {
        return $user->hasPermission('update.setting') || $user->id == $setting->user_id;
    }

    /**
     * Determine whether the user can delete the DocSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return bool
     */
    public function delete(User $user, Setting $setting): bool
    {
        return  $user->hasPermission('delete.setting') || $user->id == $setting->user_id;
    }

    /**
     * Determine whether the user can restore the DocSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return bool
     */
    public function restore(User $user, Setting $setting): bool
    {
         return $user->hasPermission('restore.setting') || $user->id == $setting->user_id;
    }

    /**
     * Determine whether the user can permanently delete the DocSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return bool
     */
    public function forceDelete(User $user, Setting $setting): bool
    {
        return $user->hasPermission('forcedelete.setting') || $user->id == $setting->user_id;		
    }
}