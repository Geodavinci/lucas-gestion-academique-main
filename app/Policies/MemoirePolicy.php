<?php

namespace App\Policies;

use App\Models\Memoire;
use App\Models\User;

class MemoirePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'student'], true);
    }

    public function view(User $user, Memoire $memoire): bool
    {
        return $user->role === 'admin'
            || (
                $user->role === 'student'
                && $user->student?->id === $memoire->student_id
            );
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Memoire $memoire): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'student'
            && $user->student?->id === $memoire->student_id
            && $memoire->canBeEdited();
    }

    public function delete(User $user, Memoire $memoire): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'student'
            && $user->student?->id === $memoire->student_id
            && $memoire->status === 'draft';
    }

    public function submit(User $user, Memoire $memoire): bool
    {
        return $user->role === 'student'
            && $user->student?->id === $memoire->student_id
            && $memoire->canBeEdited();
    }

    public function review(User $user, Memoire $memoire): bool
    {
        return $user->role === 'admin';
    }

    public function approve(User $user, Memoire $memoire): bool
    {
        return $user->role === 'admin';
    }

    public function reject(User $user, Memoire $memoire): bool
    {
        return $user->role === 'admin';
    }

    public function requestChanges(User $user, Memoire $memoire): bool
    {
        return $user->role === 'admin';
    }
}
