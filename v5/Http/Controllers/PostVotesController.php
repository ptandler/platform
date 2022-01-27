<?php

namespace v5\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use v5\Events\PostCreatedEvent;
use v5\Events\PostUpdatedEvent;
use v5\Http\Resources\PostVotesResource;
use v5\Models\Post\Post;
use v5\Models\PostVotes;
use Illuminate\Support\Facades\DB;

class PostVotesController extends V5Controller
{
    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return JsonResponse|PostVotesResource
     */
    public function showAll(int $id)
    {
        // TODO:PET validate post $id!!
        // TODO:PET check authorization: only admin & backend users are allowed to read all votes for a post!
        $votes = PostVotes::where('post_id', $id)->get();
        return new PostVotesResource($votes);
    } //end showAll()

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @param  int     $user_id
     * @return JsonResponse|PostVotesResource
     */
    public function show(int $id, int $user_id)
    {
        // TODO:PET validate post $id and $user_id!!
        // TODO:PET check authorization: only user is allowed to see his/her vote
        $votes = PostVotes::where('post_id', $id)->where('user_id', $user_id)->get();
        return new PostVotesResource($votes);
    } //end show()

    /**
     * insert or update a vote
     *
     * @TODO  transactions =)
     * @param integer $id
     * @param Request $request
     */
    public function update(int $id, int $user_id, Request $request)
    {
        // TODO:PET validate post $id and $user_id!!
        // TODO:PET check authorization: only user is allowed to change the vote

        $vote = PostVotes::where('post_id', $id)->where('user_id', $user_id)->first();
        if (!$vote) {
            // create a new one
            $vote = new PostVotes;
            $vote->fill(['post_id' => $id, 'user_id' => $user_id]);
        }

        $input = $request->input();

        if ($input['vote']) {
            $vote->vote = $input['vote'];
            $vote->save();
        }
    } //end update()

    /**
     * @param integer $id
     * @param Request $request
     */
    public function delete(int $id, Request $request)
    {
        // TODO:PET implement
    } //end delete()

    /**
     * Not all fields are things we want to allow on the body of requests
     * an author won't change after the fact so we limit that change
     * to avoid issues from the frontend.
     *
     * @return string[]
     */
    protected function ignoreInput()
    {
        return ['post_id', 'user_id', 'created', 'updated'];
    }
}//end class
