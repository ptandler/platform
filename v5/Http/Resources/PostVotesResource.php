<?php

namespace v5\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

/**
 * The `PostVotesResource` returns the aggregated votes for the post (sum, avg. count)
 * and optionally (i.e. when $include_details is true) the full details
 */
class PostVotesResource extends Resource
{
    /**
     * @var bool if true, the ressource will also return all the information about who votes with which value when
     */
    protected $include_details = false;

    /**
     * create a `PostVotesResource` that also returns all the details about the individual votes
     *
     * @param $resource
     * @return PostVotesResource
     */
    public static function withDetails($resource): PostVotesResource
    {
        $instance = new self($resource);
        $instance->include_details = true;
        return $instance;
    }

    public function toArray($request): array
    {
        $arr = [
            'sum' => $this->resource->sum('vote'),
            'avg' => $this->resource->avg('vote'),
            'count' => $this->resource->count(),
        ];
        $user_id = Auth::id();
        if ($user_id) {
//            $arr['current_user'] = $user_id;
            // TODO: is this performant enough and scales well?
            //       would firstWhere speed up access? Should be exactly one row per post x user anyway
            $arr['current_user_vote'] = $this->resource->where('user_id', $user_id)->sum('vote');
        }
        if ($this->include_details) {
/*
            $arr['votes'] = $this->resource->map(function ($item) {
                return $item->vote;
            });
*/
            $arr['result'] = parent::toArray($request);
        }
        return $arr;
    }
}
