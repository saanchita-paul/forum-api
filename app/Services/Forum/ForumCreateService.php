<?php

namespace App\Services\Forum;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Forum Create Service
 */
class ForumCreateService
{
    /**
     * Add new forum with an image
     *
     * @param Request $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function addForum(Request $data)
    {
        try {
            $forum = new Forum();
            $forum->user_id = $data->user_id;
            $forum->title = $data->title;
            $forum->body = $data->body;
            $forum->save();

            return response()->json([
                'message' => 'Forum Created',
                'status' => true,
                'forum' => $forum,
            ]);

        } catch (\Throwable $th) {
            Log::error('ErrorFrom::ForumCreateService::addForum()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }
}

