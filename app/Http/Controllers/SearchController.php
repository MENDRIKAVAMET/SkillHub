<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));

        $users = collect();
        $skills = collect();

        if ($query !== '') {
            $users = User::query()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%");
                })
                ->select(['id', 'name', 'email', 'city', 'photo'])
                ->orderBy('name')
                ->paginate(8)
                ->appends(['q' => $query]);

            $skills = Skill::query()
                ->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->select(['id', 'name', 'description'])
                ->orderBy('name')
                ->paginate(8)
                ->appends(['q' => $query]);
        }

        return view('search.index', compact('query', 'users', 'skills'));
    }
}
