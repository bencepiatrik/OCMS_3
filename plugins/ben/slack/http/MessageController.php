<?php namespace Ben\Slack\Http;

use Illuminate\Http\Request;
use Ben\Slack\Models\Message;
use System\Models\File;

class MessageController
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'chat_id' => 'required|exists:ben_slack_chats,id',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf',
        ]);

        $message = new Message();
        $message->chat_id = $validatedData['chat_id'];
        $message->content = $validatedData['content'];

        $user = $request->input('authenticated_user');

        $message->user_id = $user->id;

        $message->save();

        if ($request->hasFile('attachment')) {
            $file = new File();
            $file->fromPost($request->file('attachment'));
            $message->attachment()->add($file);
        }

        return response()->json(['message' => 'Message created successfully', 'data' => $message], 201);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf',
        ]);

        // Find the message
        $message = Message::findOrFail($id);
        $message->content = $validatedData['content'];
        $message->save();

        // Check if new attachment exists
        if ($request->hasFile('attachment')) {
            // Remove old attachment if it exists

            $file = new File();
            $file->fromPost($request->file('attachment'));
            $message->attachment()->add($file);
        }

        return response()->json(['message' => 'Message updated successfully', 'data' => $message], 200);
    }

    public function show($id)
    {
        $message = Message::with('attachment')->findOrFail($id);

        return response()->json(['data' => $message], 200);
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);

        if ($message->attachment) {
            $message->attachment->delete(); // Delete the file attachment
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully'], 200);
    }
}
