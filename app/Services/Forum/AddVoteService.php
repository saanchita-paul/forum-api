<?php

namespace App\Services\Forum;

use App\Models\Forum;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class AddVoteService
{
    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVote(Request $request, $forumId)
    {
        try {
            $forum = Forum::findOrFail($forumId);
            $userId = $request->user_id;
            $voteType = $request->vote_type;

            // Check if the user has already voted for this forum
            $existingVote = $forum->votes()->where('user_id', $userId)->first();

            if ($existingVote) {
                // User has already voted, so update the existing vote
                $existingVote->vote_type = $voteType;
                $existingVote->save();
            } else {
                // User hasn't voted, so create a new vote
                $vote = new Vote();
                $vote->user_id = $userId;
                $vote->vote_type = $voteType;
                $forum->votes()->save($vote);
            }

            return response()->json([
                'message' => 'Vote added successfully.',
                'status' => true,
                'vote' => $vote ?? $existingVote,
            ]);
        } catch (\Throwable $th) {
            Log::error('ErrorFrom::AddVoteService::addVote()', [$th->getMessage(), $th->getTraceAsString()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}

