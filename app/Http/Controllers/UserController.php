<?php

namespace App\Http\Controllers;

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

    public function postSignIn(Request $request)
    {


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

    public function postSaveAccount(Request $request)
    {
//        dump($request);
        $this->validate($request, [
            'first_name' => 'required|max:120',
            'second_name' => 'required|max:120'
        ]);
        $user = Auth::user();
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
        return redirect()->route('account');
    }

    public function getUserImage($filename){
        $file = Storage::disk('local')->get($filename);
        return new Response($file,200);
    }

    public function getPage($id)
    {

        $user = Auth::user();
        if ($id == $user->id) {
            $posts = DB::table('posts')->where('user_id', $user->id)->get();
            $posts_count = DB::table('posts')->where('user_id', $user->id)->count();
            $users = User::all();
            $likes = 0;
            $dislikes = 0;
            foreach ($posts as $post) {
                foreach ($users as $user_loop) {
                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('user_id', $user->id)->where('like', 1)->count();
                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                }
                $post->likes = $likes;
                $post->dislikes = $dislikes;
                $likes = 0;
                $dislikes = 0;
            }
//        $user = DB::table('users')->where('name', 'John')->first();

            return view('userpage', ['user' => $user, 'posts' => $posts, 'posts_count' => $posts_count, 'likes' => $likes, 'dislikes' => $dislikes]);
        }


        else{
            $user = User::find($id);
            $posts = DB::table('posts')->where('user_id', $user->id)->get();
            $posts_count = DB::table('posts')->where('user_id', $user->id)->count();
            $users = User::all();
            $likes = 0;
            $dislikes = 0;
            foreach ($posts as $post) {
                foreach ($users as $user_loop) {
                    $likes += $user_loop->likes()->where('post_id', $post->id)->where('user_id', $user->id)->where('like', 1)->count();
                    $dislikes += $user_loop->likes()->where('post_id', $post->id)->where('like', 0)->count();
                }
                $post->likes = $likes;
                $post->dislikes = $dislikes;
                $likes = 0;
                $dislikes = 0;
            }
//        $user = DB::table('users')->where('name', 'John')->first();

            return view('userpage', ['user' => $user, 'posts' => $posts, 'posts_count' => $posts_count, 'likes' => $likes, 'dislikes' => $dislikes]);
        }
    }


}