<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumRequest;
use App\Services\Forum\AddCommentService;
use App\Services\Forum\AddVoteService;
use App\Services\Forum\ForumCreateService;
use App\Services\Forum\ForumDetailService;
use App\Services\Forum\ForumListService;
use App\Services\Forum\GetCommentService;
use App\Services\Forum\VoteCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class ForumController extends Controller
{
    /**
     * @param ForumRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function createForum(ForumRequest $request)
    {
        try {
            $createForum = new ForumCreateService();
            $forum = $createForum->addForum($request);
            if ($forum) {
                return $forum;
            } else {
                return 'Forum not created';
            }
        }
        catch (\Throwable $th) {
            Log::error('An error occurred: ',[$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function forumList(Request $data)
    {
        try {
            $forumList = new ForumListService();
            return $forumList->list($data);
        }
        catch (\Throwable $th) {
            Log::error('An error occurred: ',[$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forumDetails($id)
    {
        try {
            $forumDetails = new ForumDetailService();
            return $forumDetails->singleForum($id);
        }
        catch (\Throwable $th) {
            Log::error('An error occurred: ',[$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments(Request $request, $forumId)
    {
        try {
            $commentService = new GetCommentService();
            return $commentService->comments($request, $forumId);
        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVote(Request $request, $forumId)
    {
        try {
            $voteService = new AddVoteService();
            return $voteService->addVote($request, $forumId);
        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * @param Request $request
     * @param $forumId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, $forumId)
    {
        try {
            $commentService = new AddCommentService();
            return $commentService->addComment($request, $forumId);
        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * @param Request $request
     * @param $commentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function voteComment(Request $request, $commentId)
    {
        try {
            $voteService = new VoteCommentService();
            return $voteService->voteComment($request, $commentId);
        } catch (\Throwable $th) {
            Log::error('An error occurred:', [$th->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
