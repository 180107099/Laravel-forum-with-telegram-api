<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Telegram;
use App\Models\DiscussionReply;
use App\Models\Forum; 
use App\Notifications\NewTopic;
use App\Notifications\NewReply;
use App\Models\User;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $forums = Forum::latest()->get();
        $forum = Forum::find($id);

        return \view('client.new-topic', \compact('forums', 'forum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notify = 0;

        if ($request->notify && $request->notify =="on"){
            $notify = 1;
        }

        $topic = new Discussion;
        $topic->title = $request->title;
        $topic->desc = $request->desc;
        $topic->forum_id = $request->forum_id;
        $topic->user_id = auth()->id();
        $topic->notify = $notify;

        $topic->save();
        
        $user = auth()->user();
        $user->increment('rank', 10);

        $latestTopic = Discussion::latest()->first();
        $admins = User::where('is_admin', 1)->get();
        
        foreach($admins as $admin){
             $admin->notify(new NewTopic($latestTopic));
         }
         Telegram::sendMessage([
            'chat_id'=>env('TELEGRAM_CHAT_ID', '-646417817'),
            'parse_mode' =>'HTML',
            'text'=>'<b>'.auth()->user()->name."</b>"." Started a new Discussion "."<b>".$latestTopic->title.'</b>'
        ]);

         toastr()->success('Discussion Started successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Discussion::find($id);
        if($topic){
            $topic->increment('views', 1);
        }
        return view('client.topic', \compact('topic'));
    }

    /**
     * save reply to the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $reply = new DiscussionReply;
        $reply->desc = $request->desc;
        $reply->user_id = auth()->id();
        $reply->discussion_id = $id;
        $discussion=Discussion::find($id);
        $forumId = $discussion->forum->id;
        $url = \URL::to('/forum/overview/'. $forumId);

        $reply->save();

        $user = auth()->user();
        $user->increment('rank', 10);

        $latestReply = DiscussionReply::latest()->first();
        $admins = User::where('is_admin', 2)->get();
        
        foreach($admins as $admin){
             $admin->notify(new NewReply($latestReply));
         }

        Telegram::sendMessage([
            'chat_id'=>env('TELEGRAM_CHAT_ID', '-646417817'),
            'parse_mode' =>'HTML',
            'text'=>'<b>'.auth()->user()->name."</b>"." Replied to the topic "."<b>".$discussion->title." : "."</b>"."\n"."<a href='".$url."'>Read it here</a>"
        ]);
        toastr()->success('Reply saved successfully!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply = DiscussionReply::find($id);
        $reply->delete();
        toastr()->success('Reply deleted successfully!');
        return back();
    }

    public function updates(){
        $updates = Telegram::getUpdates();
        
    }
    public function remove($id){
        $discussion = DiscussionReply::find($id);
        $discussion->delete();
        toastr()->success('Reply deleted successfully!');
        return back();
    }

    public function like($id){
        $reply = DiscussionReply::find($id);
        $user_id = $reply->user_id;

        $liked = ReplyLike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->get();
        
        if(count($liked > 0)){
            toastr()->error('You already liked the reply');
            return back();
        }

        $reply_like = new ReplyLike;
        $reply_like->user_id = auth()->id();
        $reply_like->reply_id = $id;
        $reply_like->save();
        $owner = User::find($user_id);
        $reply->increment('likes', 1);
        $owner->increment('rank', 10);
        toastr()->success('Like saved successfully!');
        return back();
    }

    public function dislike($id){
        $reply = DiscussionReply::find($id);
        $user_id = $reply->user_id;

        $disliked = ReplyDislike::where('user_id', auth()->id())->where('reply_id', $id)->get();
        
        if(count($disliked > 0)){
            toastr()->error('You already disliked the reply');
            return back();
        }

        $reply_dislike = new ReplyDislike;
        $reply_dislike->user_id = auth()->id();
        $reply_dislike->reply_id = $id;
        $reply_dislike->save();
        $reply = DiscussionReply::find($id);
        $user_id = $reply->id;
        $owner = User::find($user_id);
        $reply->increment('dislikes', 1);
        $owner->decrement('rank', 10);
        toastr()->success('Dislike saved successfully!');
        return back();
    }
}
