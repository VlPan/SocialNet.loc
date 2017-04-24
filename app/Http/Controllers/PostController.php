<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function getDashboard()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $users = User::all();
        $likes = 0;
        $dislikes = 0;
        foreach ($posts as $post){
            foreach ($users as $user){
                $likes += $user->likes() -> where('post_id',$post->id)-> where('user_id', $user->id)-> where('like',1) -> count();
                $dislikes += $user->likes() -> where('post_id',$post->id)-> where('like',0)                  -> count();
            }
            $post->likes = $likes;
            $post->dislikes = $dislikes;
            $likes = 0;
            $dislikes = 0;
        }

        return view('dashboard', ['posts' => $posts,'user'=>$user,'users'=>$users,'likes'=>$likes,'dislikes'=>$dislikes]);
    }



    public function postCreatePost(Request $request)
    {
        //TO-DO: Validation
        $this->validate($request, [
            'body' => 'required|max:1000'

        ]);
        $post = new Post();
        $post->body = $request['body'];
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function getDeletePost($post_id)
    {
        $post = Post::find($post_id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }

        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully Deleted']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'

        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);

    }

    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }

        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        }else{
            $like->save();
        }
        return null;
    }
}
