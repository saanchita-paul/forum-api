<?php

namespace App\Services\Forum;

use App\Models\Comment;
use App\Models\Forum;
use App\Notifications\CommentNotification;
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
            $forum = Forum::with('user')
                ->where('id',$forumId)
                ->firstOrFail();

            $comment = new Comment();
            $comment->user_id = $request->user_id;
            $comment->body = $request->body;
            $forum->comments()->save($comment);

            $this->notifyForumCreator($forum);
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


    private function notifyForumCreator(Forum $forum)
    {
        if($forum->user->id !== auth()->id()) {
            $forum->user->notify(new CommentNotification($forum->id));
        }
    }
}

