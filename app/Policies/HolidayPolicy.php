<?php

namespace App\Policies;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HolidayPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_holiday');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Holiday $holiday): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_holiday');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Holiday $holiday): bool
    {
        return $user->can('update_holiday');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_holiday');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Holiday $holiday): bool
    {
        return $user->can('delete_holiday');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_holiday');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Holiday $holiday): bool
    {
        return $user->can('restore_holiday');
    }

    /**
     * Determine whether the user can force permanently delete the model.
     */
    public function forceDelete(User $user, Holiday $holiday): bool
    {
        return $user->can('force_delete_holiday');
    }

    /**
     * Determine whether the user can force permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_holiday');
    }
}
