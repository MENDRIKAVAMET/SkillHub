<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load(['skills' => function ($query) {
            $query->withPivot('level');
        }]);

        $learningRequestsCount = $user->learningRequests()->count();
        $helpRequestsSentCount = $user->sentHelpRequests()->count();
        $helpRequestsReceivedCount = $user->receivedHelpRequests()->count();

        return view('users.show', compact('user', 'learningRequestsCount', 'helpRequestsSentCount', 'helpRequestsReceivedCount'));
    }
}
