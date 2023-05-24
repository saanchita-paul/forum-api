<?php

namespace App\Services\Forum;

use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class AddCommentService
{
    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, $forumId)
    {
        try {
            $forum = Forum::findOrFail($forumId);

            $comment = new Comment();
            $comment->user_id = $request->user_id;
            $comment->body = $request->body;
            $forum->comments()->save($comment);

            return response()->json([
                'message' => 'Comment added successfully.',
                'status' => true,
                'comment' => $comment,
            ]);
        } catch (\Throwable $th) {
            Log::error('ErrorFrom::AddCommentService::addComment()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }

}

