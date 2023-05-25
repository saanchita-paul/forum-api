<?php

namespace App\Services\Forum;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class ForumListService
{
    /**
     * @param Request $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function list(Request $data)
    {
        try {
            $forum =  Forum::query()
                ->with('user')
                ->where('title', 'like', "%{$data->get('search')}%")
                ->orderBy('id', 'desc')
                ->paginate($data->get('per_page'));

            // Fetch the votes count for each forum
            $forum->each(function ($forumItem) {
                $upVoteCount = $forumItem->votes()->where('vote_type', 'up_vote')->count();
                $downVoteCount = $forumItem->votes()->where('vote_type', 'down_vote')->count();

                // Attach the vote counts to each forum item
                $forumItem->total_up_vote = $upVoteCount;
                $forumItem->total_down_vote = $downVoteCount;
            });

            return response()->json($forum);

        } catch (\Throwable $th) {
            Log::error('ErrorFrom::ForumListService::list()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }
}

