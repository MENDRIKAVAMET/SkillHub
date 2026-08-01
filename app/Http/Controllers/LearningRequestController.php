<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningRequestRequest;
use App\Http\Requests\UpdateLearningRequestRequest;
use App\Models\LearningRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LearningRequestController extends Controller
{
    public function index(): View
    {
        $requests = LearningRequest::with(['user', 'skill'])
            ->latest()
            ->paginate(10);

        return view('learning-requests.index', compact('requests'));
    }

    public function create(): View
    {
        $skills = Skill::orderBy('name')->get();
        $matchedMentors = collect();

        return view('learning-requests.create', compact('skills', 'matchedMentors'));
    }

    public function store(StoreLearningRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = 'En attente';

        LearningRequest::create($data);

        return redirect()->route('learning-requests.index')->with('success', 'Besoin d\'apprentissage créé avec succès.');
    }

    public function show(LearningRequest $learningRequest): View
    {
        $this->authorize('view', $learningRequest);
        $learningRequest->load(['user', 'skill']);

        $matchedMentors = User::whereHas('skills', function ($query) use ($learningRequest) {
            $query->where('skills.id', $learningRequest->skill_id)
                  ->wherePivot('level', '!=', 'Débutant');
        })->with(['skills' => function ($query) use ($learningRequest) {
            $query->where('skills.id', $learningRequest->skill_id)->withPivot('level');
        }])->get();

        return view('learning-requests.show', compact('learningRequest', 'matchedMentors'));
    }

    public function edit(LearningRequest $learningRequest): View
    {
        $this->authorize('update', $learningRequest);
        $skills = Skill::orderBy('name')->get();

        return view('learning-requests.edit', compact('learningRequest', 'skills'));
    }

    public function update(UpdateLearningRequestRequest $request, LearningRequest $learningRequest): RedirectResponse
    {
        $this->authorize('update', $learningRequest);
        $learningRequest->update($request->validated());

        return redirect()->route('learning-requests.index')->with('success', 'Besoin d\'apprentissage mis à jour avec succès.');
    }

    public function destroy(LearningRequest $learningRequest): RedirectResponse
    {
        $this->authorize('delete', $learningRequest);
        $learningRequest->delete();

        return redirect()->route('learning-requests.index')->with('success', 'Besoin d\'apprentissage supprimé avec succès.');
    }

    public function match($skillId)
    {
        $mentors = User::whereHas('skills', function ($query) use ($skillId) {
            $query->where('skills.id', $skillId)
                  ->wherePivot('level', '!=', 'Débutant');
        })->with(['skills' => function ($query) use ($skillId) {
            $query->where('skills.id', $skillId)->withPivot('level');
        }])->get()
        ->map(function ($mentor) {
            return [
                'id' => $mentor->id,
                'name' => $mentor->name,
                'city' => $mentor->city,
                'level' => $mentor->skills->first()->pivot->level ?? '',
            ];
        });

        return response()->json(['mentors' => $mentors]);
    }
}
