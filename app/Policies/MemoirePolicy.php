<?php

namespace App\Policies;

use App\Models\Memoire;
use App\Models\User;

class MemoirePolicy
{
    public function view(User $user, Memoire $memoire): bool
    {
        // Admin can view all
        if ($user->role === 'admin') {
            return true;
        }

        // Student can view their own
        if ($user->student && $user->student->id === $memoire->student_id) {
            return true;
        }

        return false;
    }

    public function update(User $user, Memoire $memoire): bool
    {
        // Admin can update/review all
        if ($user->role === 'admin') {
            return true;
        }

        // Student can edit their own draft/changes_requested
        if ($user->student && $user->student->id === $memoire->student_id) {
            return $memoire->canBeEdited();
        }

        return false;
    }

    public function delete(User $user, Memoire $memoire): bool
    {
        // Admin can delete all
        if ($user->role === 'admin') {
            return true;
        }

        // Student can delete their own draft
        if ($user->student && $user->student->id === $memoire->student_id) {
            return $memoire->status === 'draft';
        }

        return false;
    }
}
