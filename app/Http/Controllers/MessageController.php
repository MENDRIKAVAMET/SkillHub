<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    /**
     * Récupère les messages échangés avec $user postérieurs à after_id (pour le polling AJAX).
     */
    public function poll(User $user, Request $request): JsonResponse
    {
        $authUser = auth()->user();
        $afterId = (int) $request->query('after_id', 0);

        $messages = Message::query()
            ->select(['id', 'sender_id', 'receiver_id', 'content', 'created_at'])
            ->where('id', '>', $afterId)
            ->where(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
            })->with('sender')->oldest()->get();

        return response()->json([
            'messages' => $messages->map(fn (Message $msg) => [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name,
                'content' => $msg->content,
                'time' => $msg->created_at->format('H:i'),
                'is_mine' => $msg->sender_id === $authUser->id,
                'delete_url' => route('messages.destroy', $msg),
            ]),
        ]);
    }

    public function store(StoreMessageRequest $request): RedirectResponse|JsonResponse
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        if ($request->wantsJson()) {
            $message->load('sender');

            return response()->json([
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name,
                    'content' => $message->content,
                    'time' => $message->created_at->format('H:i'),
                    'is_mine' => true,
                    'delete_url' => route('messages.destroy', $message),
                ],
            ]);
        }

        return redirect()->route('messages.show', ['user' => $request->receiver_id])->with('success', 'Message envoyé.');
    }

    public function destroy(Message $message, Request $request): RedirectResponse|JsonResponse
    {
        $this->authorize('delete', $message);
        $message->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Message supprimé.');
    }
}
