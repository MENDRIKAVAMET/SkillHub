<?php

namespace App\Policies;

use App\Models\HelpRequest;
use App\Models\User;

class HelpRequestPolicy
{
    public function view(User $user, HelpRequest $helpRequest): bool
    {
        return $user->id === $helpRequest->sender_id || $user->id === $helpRequest->receiver_id;
    }

    public function update(User $user, HelpRequest $helpRequest): bool
    {
        return $user->id === $helpRequest->sender_id || $user->id === $helpRequest->receiver_id;
    }

    public function delete(User $user, HelpRequest $helpRequest): bool
    {
        return $user->id === $helpRequest->sender_id || $user->id === $helpRequest->receiver_id;
    }
}
