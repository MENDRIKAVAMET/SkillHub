<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::latest()->get();

        return view('skills.index', compact('skills'));
    }

    public function create(): View
    {
        return view('skills.create');
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return redirect()->route('skills.index')->with('status', 'skill-created');
    }

    public function show(Skill $skill): View
    {
        return view('skills.show', compact('skill'));
    }

    public function edit(Skill $skill): View
    {
        $this->authorize('update', $skill);

        return view('skills.edit', compact('skill'));
    }

    public function update(UpdateSkillRequest $request, Skill $skill): RedirectResponse
    {
        $this->authorize('update', $skill);
        $skill->update($request->validated());

        return redirect()->route('skills.index')->with('status', 'skill-updated');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $this->authorize('delete', $skill);
        $skill->delete();

        return redirect()->route('skills.index')->with('status', 'skill-deleted');
    }
}
