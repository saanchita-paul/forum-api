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
            return Forum::query()
                ->where('title', 'like', "%{$data->get('search')}%")
                ->orderBy('id', 'desc')
                ->paginate($data->get('per_page'));

        } catch (\Throwable $th) {
            Log::error('ErrorFrom::ForumListService::list()', [$th->getMessage(), $th->getTraceAsString()]);
            return $th;
        }
    }
}

