<?php

namespace App\Services\Forum;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditCommentService
{
    public function editComment($commentId, Request $request)
    {
        $comment = Comment::findOrFail($commentId);
//        dd(Auth::id());
        // Check if the logged-in user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            throw new \Exception('You are not authorized to edit this comment.');
        }

        // Update the comment with the new content
        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully.',
            'status' => true,
            'comment' => $comment,
        ]);
    }

}
