<?php

namespace App\Services\Forum;

use App\Models\Forum;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class ForumDetailService
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function singleForum($id)
    {
        try {
            $forum = Forum::where('id', $id)
                ->with('comments')
                ->firstOrFail();

            $voteCount = $forum->votes()->count();
            $upVoteCount = $forum->votes()->where('vote_type', 'up_vote')->count();
            $downVoteCount = $forum->votes()->where('vote_type', 'down_vote')->count();
            $upVotedBy = $forum->votes()
                                ->with('user')
                                ->where('vote_type', 'up_vote')
                                ->get()->unique('user_id');
            $downVotedBy = $forum->votes()
                ->with('user')
                ->where('vote_type', 'down_vote')
                ->get()->unique('user_id');

            $commentCount = $forum->comments()->count();

            return response()->json([
                'status' => true,
                'forum' => $forum,
                'total_forum_vote' => $voteCount,
                'total_comment_vote' => $commentCount,
                'forum_up_vote_count' => $upVoteCount,
                'forum_down_vote_count' => $downVoteCount,
                'forum_up_voted_by' => $upVotedBy,
                'forum_down_voted_by' => $downVotedBy,
            ]);
        } catch (\Throwable $th) {
            Log::error('ErrorFrom::ForumDetailService::singlePost()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }
}

