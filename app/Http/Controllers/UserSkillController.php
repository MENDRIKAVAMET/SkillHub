<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSkillRequest;
use App\Http\Requests\UpdateUserSkillRequest;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserSkillController extends Controller
{
    public function index(): View
    {
        $userSkills = auth()->user()->skills()->withPivot('level')->get();
        $skills = Skill::all();

        return view('user_skills.index', compact('userSkills', 'skills'));
    }

    public function create(): View
    {
        $skills = Skill::all();

        return view('user_skills.create', compact('skills'));
    }

    public function store(StoreUserSkillRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->skills()->syncWithoutDetaching([
            $request->skill_id => ['level' => $request->level],
        ]);

        return redirect()->route('user-skills.index')->with('status', 'user-skill-created');
    }

    public function edit(UserSkill $userSkill): View
    {
        $skills = Skill::all();
        $currentLevel = $userSkill->pivot->level ?? $userSkill->level;

        return view('user_skills.edit', compact('userSkill', 'skills', 'currentLevel'));
    }

    public function update(UpdateUserSkillRequest $request, UserSkill $userSkill): RedirectResponse
    {
        $userSkill->update($request->validated());

        return redirect()->route('user-skills.index')->with('status', 'user-skill-updated');
    }

    public function destroy(UserSkill $userSkill): RedirectResponse
    {
        $userSkill->delete();

        return redirect()->route('user-skills.index')->with('status', 'user-skill-deleted');
    }
}
