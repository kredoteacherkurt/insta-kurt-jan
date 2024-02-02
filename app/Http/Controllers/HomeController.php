<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // [1]
        // return view('users.home');
        // [2]
        // $all_posts = $this->post->latest()->get();
        // return view('users.home')->with('all_posts', $all_posts);
        // [3]
        // $home_posts = $this->getHomePosts();
        // return view('users.home')->with('home_posts', $home_posts);
        // [4]
        $home_posts = $this->getHomePosts();
        $suggested_users = array_slice($this->getSuggestedUsers(),0,10);

        return view('users.home')
            ->with('home_posts', $home_posts)
            ->with('suggested_users', $suggested_users);
    }

    //show the Auth user’ and its following’s post. getHomePosts() 
    public function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id == Auth::user()->id) {
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }

    // Create getSuggestedUsers method in HomeController
    public function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }
        return $suggested_users;
    }

    //Show a full-page list of suggested users (users that you are not following) suggestions()
    public function suggestions()
    {
        $suggested_users = $this->getSuggestedUsers();
        return view('users.suggestions')->with('suggested_users', $suggested_users);
    }

    //search
    public function search(Request $request)
    {
        $users = $this->user->where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
