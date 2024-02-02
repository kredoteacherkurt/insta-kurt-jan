<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(){
        //[1] get all users
        // $all_users = $this->user->latest()->get();
        // [2] get all users with pagination
        // $all_users = $this->user->latest()->paginate(8);
        // [3] get all users with pagination and soft deleted users
        $all_users = $this->user->withTrashed()->latest()->paginate(8);
        return view('admin.users.index')->with('all_users', $all_users);
    }

    //deactivate user
    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    //activate user
    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
