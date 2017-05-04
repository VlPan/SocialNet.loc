<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Friends;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function postSignUp(Request $request)
    {
        $this->validate($request, [

            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:8'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();
        Auth::login($user);
        return redirect()->route('dashboard');

    }

    public function postSignUpFromAdmin(Request $request)
    {
        $this->validate($request, [

            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:8'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();

        return redirect()->back();

    }

    public function postSignIn(Request $request)
    {

        if($request['email'] === 'admin' and $request['password'] === 'admin'){
            return redirect()->route('admin');
        }
//        dump($request['email']);
//        dump($request['password']);

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);


        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request,$id)
    {

        $this->validate($request, [
            'first_name' => 'required|max:120',
            'second_name' => 'required|max:120'
        ]);

        if(Auth::user()){
            $user = Auth::user();
        }
        else{
            $user = User::find($id);
        }

        $old_name = $user->first_name;
        $user->second_name = $request['second_name'];
        $user->city = $request['city'];
        $user->country = $request['country'];
        $user->gender = $request['gender'];
        $user->status = $request['status'];
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        if(Auth::user()){
            return redirect()->route('account');
        }
        else{
            return redirect()->route('admin');
        }

    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    public function getPage($id)
    {

        $user_id = Auth::user()->id;
        if ($id == $user_id) {
            $user = Auth::user();
            $posts = DB::table('posts')->where('user_id', $user->id)->get();
            $posts_count = DB::table('posts')->where('user_id', $user->id)->count();
            $users = User::all();
            $friends = Friend::where('id_getter', $id)->orWhere('id_sender', $user->id)->get();
            $likes = 0;
            $dislikes = 0;
            foreach ($posts as $post) {
                foreach ($users as $user_loop) {
//                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('user_id', $user->id)->where('like', 1)->count();
//                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('user_id', $user_loop->id)->where('like', 1)->count();
                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                }
                $post->likes = $likes;
                $post->dislikes = $dislikes;
                $likes = 0;
                $dislikes = 0;
            }
//        $user = DB::table('users')->where('name', 'John')->first();

            return view('userpage', ['user' => $user, 'posts' => $posts, 'posts_count' => $posts_count, 'likes' => $likes, 'dislikes' => $dislikes, 'friends' => $friends]);
        } else {
            $user = User::find($id); // 7
            $posts = DB::table('posts')->where('user_id', $user->id)->get();
            $friends = Friend::where('id_getter', $user->id)->orWhere('id_sender', $user->id)->get();
            $posts_count = DB::table('posts')->where('user_id', $user->id)->count();
            $users = User::all();
            $likes = 0;
            $dislikes = 0;
            foreach ($posts as $post) {
                foreach ($users as $user_loop) {
//                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('like', 1)->count();
//                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('user_id', $user_loop->id)->where('like', 1)->count();
                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                }
                $post->likes = $likes;
                $post->dislikes = $dislikes;
                $likes = 0;
                $dislikes = 0;
            }
//        $user = DB::table('users')->where('name', 'John')->first();

            return view('userpage', ['user' => $user, 'posts' => $posts, 'posts_count' => $posts_count, 'likes' => $likes, 'dislikes' => $dislikes, 'friends' => $friends]);
        }
    }

    public function addFriend($id)
    {

        $id_getter = $id;
        $id_sender = Auth::user()->id;

//Если тек пользователь является либо sender либо getter
        $user = User::find($id);
        $is_friends = \App\Friend::where('id_sender',Auth::user()->id)->where('id_getter',$user->id)->first() || \App\Friend::where('id_getter',Auth::user()->id)->where('id_sender',$user->id)->first();

//        \App\Friend::where('id_sender',Auth::user()->id)->where('id_getter',$user->id)->first() || \App\Friend::where('id_getter',Auth::user()->id)->where('id_sender',$user->id)->first()
//        $is_friends = Friend::where('id_sender', $id_sender)->where('id_getter', $id_getter)->first();

        if ($is_friends) {
            $is_friends = Friend::where('id_sender', $id_sender)->where('id_getter',                    $id_getter)->first();
            $is_friends->delete();
        } else {
            $friend = new Friend();
            $friend->id_getter = $id_getter;
            $friend->id_sender = $id_sender;
            $friend->save();
        }
        return redirect()->back();

    }

    public function getAdmin(){
        
        $users = User::all();
        return view('adminPanel',['users'=> $users]);
      
    }

    public function deleteUser($id){
        User::find($id)->delete();
        return redirect()->back();
    }
    
    public function changeUser($id){
       $user = User::find($id);
        return view('account',['user'=> $user]);
    }

}

