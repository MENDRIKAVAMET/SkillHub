<?php

namespace App\Http\Controllers;

use App\Models\HelpRequest;
use App\Models\LearningRequest;
use App\Models\Message;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $skillCount = Skill::count();
        $learningRequestCount = LearningRequest::count();
        $helpRequestsSent = HelpRequest::where('sender_id', $user->id)->count();
        $helpRequestsReceived = HelpRequest::where('receiver_id', $user->id)->count();
        $messageCount = Message::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })->count();

        $recentActivities = collect();
        $recentActivities = $recentActivities->merge(
            LearningRequest::with('skill')->latest()->take(3)->get()->map(function ($item) {
                return [
                    'title' => 'Besoin d’apprentissage créé',
                    'text' => $item->skill->name ?? 'Compétence',
                    'time' => $item->created_at->diffForHumans(),
                ];
            })
        )->merge(
            HelpRequest::with(['sender', 'receiver', 'skill'])->latest()->take(3)->get()->map(function ($item) {
                return [
                    'title' => 'Demande d’aide reçue',
                    'text' => $item->skill->name ?? 'Compétence',
                    'time' => $item->created_at->diffForHumans(),
                ];
            })
        )->merge(
            Message::with(['sender', 'receiver'])->latest()->take(3)->get()->map(function ($item) {
                return [
                    'title' => 'Message envoyé',
                    'text' => $item->content,
                    'time' => $item->created_at->diffForHumans(),
                ];
            })
        )->sortByDesc('time')->take(6);

        return view('dashboard', compact(
            'skillCount',
            'learningRequestCount',
            'helpRequestsSent',
            'helpRequestsReceived',
            'messageCount',
            'recentActivities'
        ));
    }
}
