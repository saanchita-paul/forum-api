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
            $userId = $request->user_id;
            $voteType = $request->vote_type;

            $existingVote = $comment->votes()->where('user_id', $userId)->first();

            if ($existingVote) {
                // User has already voted, so update the existing vote
                $existingVote->vote_type = $voteType;
                $existingVote->save();
                $vote = $existingVote;
            } else {
                // User hasn't voted, so create a new vote
                $vote = new Vote();
                $vote->user_id = $userId;
                $vote->vote_type = $voteType;
                $comment->votes()->save($vote);
            }

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

