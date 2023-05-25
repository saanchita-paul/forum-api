<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Forum\DeleteCommentService;
use App\Services\Forum\EditCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class CommentController extends Controller
{
    public function editComment($commentId, Request $request)
    {
        try {
            $comment = new EditCommentService();
            return $comment->editComment($commentId, $request);

        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteComment($commentId)
    {
        try {
            $comment = new DeleteCommentService();
            return $comment->deleteComment($commentId);

        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
