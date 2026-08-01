<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHelpRequestRequest;
use App\Http\Requests\UpdateHelpRequestRequest;
use App\Models\HelpRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpRequestController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $helpRequests = HelpRequest::with(['sender', 'receiver', 'skill'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            })
            ->latest()
            ->paginate(10);

        return view('help-requests.index', compact('helpRequests'));
    }

    public function create(): View
    {
        $users = User::where('id', '!=', auth()->id())
            ->with('skills')
            ->orderBy('name')
            ->get();
        $skills = Skill::orderBy('name')->get();

        return view('help-requests.create', compact('users', 'skills'));
    }

    public function store(StoreHelpRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sender_id'] = auth()->id();
        $data['status'] = 'En attente';

        HelpRequest::create($data);

        return redirect()->route('help-requests.index')->with('success', 'Demande d\'aide envoyée avec succès.');
    }

    public function show(HelpRequest $helpRequest): View
    {
        $this->authorize('view', $helpRequest);
        $helpRequest->load(['sender', 'receiver', 'skill']);

        return view('help-requests.show', compact('helpRequest'));
    }

    public function edit(HelpRequest $helpRequest): View
    {
        $this->authorize('update', $helpRequest);
        $users = User::where('id', '!=', auth()->id())
            ->with('skills')
            ->orderBy('name')
            ->get();
        $skills = Skill::orderBy('name')->get();

        return view('help-requests.edit', compact('helpRequest', 'users', 'skills'));
    }

    public function update(UpdateHelpRequestRequest $request, HelpRequest $helpRequest): RedirectResponse
    {
        $this->authorize('update', $helpRequest);
        $helpRequest->update($request->validated());

        return redirect()->route('help-requests.index')->with('success', 'Demande d\'aide mise à jour avec succès.');
    }

    public function destroy(HelpRequest $helpRequest): RedirectResponse
    {
        $this->authorize('delete', $helpRequest);
        $helpRequest->delete();

        return redirect()->route('help-requests.index')->with('success', 'Demande d\'aide supprimée avec succès.');
    }

    public function accept(HelpRequest $helpRequest): RedirectResponse
    {
        $this->authorize('update', $helpRequest);

        if ($helpRequest->receiver_id !== auth()->id()) {
            return back()->with('error', 'Seul le destinataire peut accepter cette demande.');
        }

        $helpRequest->update(['status' => 'Acceptée']);

        return redirect()->route('help-requests.index')->with('success', 'Demande d\'aide acceptée.');
    }

    public function refuse(HelpRequest $helpRequest): RedirectResponse
    {
        $this->authorize('update', $helpRequest);

        if ($helpRequest->receiver_id !== auth()->id()) {
            return back()->with('error', 'Seul le destinataire peut refuser cette demande.');
        }

        $helpRequest->update(['status' => 'Refusée']);

        return redirect()->route('help-requests.index')->with('success', 'Demande d\'aide refusée.');
    }
}
