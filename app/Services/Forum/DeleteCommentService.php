<?php

namespace App\Services\Forum;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteCommentService
{
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Check if the logged-in user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            throw new \Exception('You are not authorized to delete this comment.');
        }

        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted successfully.',
            'status' => true,
        ]);
    }
}
