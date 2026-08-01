<?php

namespace App\Policies;

use App\Models\LearningRequest;
use App\Models\User;

class LearningRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LearningRequest $learningRequest): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LearningRequest $learningRequest): bool
    {
        return $user->id === $learningRequest->user_id;
    }

    public function delete(User $user, LearningRequest $learningRequest): bool
    {
        return $user->id === $learningRequest->user_id;
    }
}
