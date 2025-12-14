<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    /**
     * Determine if the user can view any branches.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view branches');
    }

    /**
     * Determine if the user can view the branch.
     */
    public function view(User $user, Branch $branch): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->branch_id === $branch->id;
    }

    /**
     * Determine if the user can create branches.
     */
    public function create(User $user): bool
    {
        return $user->can('create branches');
    }

    /**
     * Determine if the user can update the branch.
     */
    public function update(User $user, Branch $branch): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            return $user->branch_id === $branch->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the branch.
     */
    public function delete(User $user, Branch $branch): bool
    {
        // Super admin can always delete
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Admin can delete their own branch
        if ($user->hasRole('admin')) {
            return $user->branch_id === $branch->id || $user->can('delete branches');
        }

        // Fallback to permission check
        return $user->can('delete branches');
    }
}

