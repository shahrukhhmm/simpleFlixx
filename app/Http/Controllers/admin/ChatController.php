<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->where('role', 'admin')->orwhere('role', 'doctor')->get();
        return view('admin.pages.chat.index', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $chat = new Chat();
        $chat->sender_id = Auth::id();
        $chat->receiver_id = $request->input('receiver_id');
        $chat->message = $request->input('message');
        $chat->save();

        return response()->json(['message' => 'Message sent successfully', 'chat' => $chat]);
    }

    public function getMessages($receiverId)
    {
        $messages = Chat::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }
}
