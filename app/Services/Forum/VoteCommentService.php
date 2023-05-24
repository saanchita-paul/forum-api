<?php

namespace App\Services\Forum;

use App\Models\Comment;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class VoteCommentService
{
    /**
     * @param Request $request
     * @param $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function voteComment(Request $request, $commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);

            $vote = new Vote();
            $vote->user_id = $request->user_id;
            $comment->votes()->save($vote);

            return response()->json([
                'status' => true,
                'message' => 'Comment voted successfully.',
                'vote' => $vote,
            ]);
        } catch (\Throwable $th) {
            Log::error('ErrorFrom::VoteCommentService::voteComment()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }

}

