<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discussion;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Setting;

class DashboardController extends Controller
{
    //
    public function home(){

        $categories = Category::latest()->paginate(15);
        $topic = Discussion::latest()->paginate(15);
        $forums = Forum::latest()->paginate(15);
        $users = User::latest()->paginate(15);
        return view('admin.pages.home', compact('categories', 'topic', 'forums', 'users'));
    }
    public function users(){
        $users = User::latest()->paginate(15);
        
        return view('admin.pages.users', compact('users'));
    }
    public function show($id){
        $user = User::find($id);
        
        $latest_user_post =  Discussion::where('user_id', $id)->latest()->first();
        
        $latest = Discussion::latest()->first();

        return view('admin.pages.user', compact('user','latest_user_post','latest'));
    }
    public function profile(){       
        $latest_user_post =  Discussion::where('user_id', auth()->id())->latest()->first();
        
        $latest = Discussion::latest()->first();
        $user = auth()->user();
        return view('admin.pages.user', compact('user','latest_user_post','latest'));
    }
    public function destroy($id){
        $users = User::find($id);
        $users->delete();
        toastr()->success('Success!');
        return back();
    }
    public function notifications(){
        $notifications = auth()->user()->notifications()->where('read_at', NULL)->get();
        return view('admin.pages.notifications', compact('notifications') );
    }
    public function markAsRead($id){
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        toastr()->info('Notification marked as read!');
        return back();
    }
    public function notificationDestroy($id){
        $notification = auth()->user()->notifications()->where('id',$id)->first();
        $notification->delete();
        toastr()->success('Success!');
        return back();
    }

    public function settingsForm(){

        return view('admin.pages.setting');
    }

    public function newSettings(Request $request){

        $set = new Setting;
        $set->forum_name = $request->forum_name;
        $set->save();
        toastr()->success('Setting saved successfully');
        return view('admin.pages.settings');
    }
}
