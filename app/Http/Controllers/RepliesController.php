<?php

namespace App\Http\Controllers;

use App\Http\Forms\CreatePostForm;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param Thread $thread
     * @param CreatePostForm $form
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreatePostForm $form)
    {
        if($this->locked){
            return response('Thread is locked',422);
        }

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Reply $reply
     * @return void
     */
    public function update(Reply $reply)
    {
        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply->update(request(['body']));

        } catch (\Exception $e) {

            return response('Sorry your reply could be saved at this time', 422);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {

        $reply->delete();

        if ($reply->user_id !== auth()->id()) {
            return response([], 403);
        }

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted!']);
        }

        return back();

    }


}
