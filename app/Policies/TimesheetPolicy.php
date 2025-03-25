<?php

namespace App\Policies;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimesheetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_timesheet');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Timesheet $timesheet): bool
    {
        return $user->can('view_timesheet');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_timesheet');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timesheet $timesheet): bool
    {
        return $user->can('update_timesheet');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_timesheet');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timesheet $timesheet): bool
    {
        return $user->can('delete_timesheet');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_timesheet');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Timesheet $timesheet): bool
    {
        return $user->can('restore_timesheet');
    }

    /**
     * Determine whether the user can force permanently delete the model.
     */
    public function forceDelete(User $user, Timesheet $timesheet): bool
    {
        return $user->can('force_delete_timesheet');
    }

    /**
     * Determine whether the user can force permanently delete any models.
     */
    public function forceDeleteAny(User $user, Timesheet $timesheet): bool
    {
        return $user->can('force_delete_any_timesheet');
    }
}
