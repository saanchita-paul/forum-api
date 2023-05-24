<?php

namespace App\Services\Forum;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 */
class GetCommentService
{
    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Request $request, $forumId)
    {
        try {
            $forum = Forum::findOrFail($forumId);
            $perPage = $request->get('per_page', 10);
            $comments = $forum->comments()
                ->with('user')
                ->paginate($perPage);

            return response()->json([
                'status' => true,
                'forum' => $forum,
                'comments' => $comments,
            ]);
        } catch (\Throwable $th) {
            Log::error('ErrorFrom::GetCommentService::comments()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }



}

