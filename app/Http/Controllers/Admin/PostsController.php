<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // show all posts
    public function index(){
        // [1] get all posts
        // $all_posts = $this->post->latest()->paginate(8);
        // [2] get all posts with trashed
        $all_posts = $this->post->withTrashed()->latest()->paginate(8);
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    // hide a post
    public function hide($id){
        $this->post->destroy($id);
        return redirect()->back();
    }

    // unhide a post
    public function unhide($id){
        $this->post->withTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    // delete a post
    public function destroy($id){
        $this->post->withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.posts.index');
    }
}


