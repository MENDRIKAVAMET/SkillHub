<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $conversations = Message::query()
            ->select(['id', 'sender_id', 'receiver_id', 'content', 'created_at'])
            ->with(['sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->latest()
            ->get()
            ->groupBy(function (Message $message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            });

        $users = User::where('id', '!=', $user->id)->orderBy('name')->get();

        return view('messages.index', compact('conversations', 'users'));
    }

    public function show(User $user): View
    {
        $authUser = auth()->user();

        $messages = Message::query()
            ->select(['id', 'sender_id', 'receiver_id', 'content', 'created_at'])
            ->where(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
            })->with(['sender', 'receiver'])->latest()->paginate(15);

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return redirect()->route('messages.show', ['user' => $request->receiver_id])->with('success', 'Message envoyé.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $this->authorize('delete', $message);
        $message->delete();

        return back()->with('success', 'Message supprimé.');
    }
}
