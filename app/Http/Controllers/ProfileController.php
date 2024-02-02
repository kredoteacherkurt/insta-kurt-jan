<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //show profile
    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    //edit profile
    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    //update profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:50',
            'email' => 'required|email|min:1|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpeg,png,jpg,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
            base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    //show followers
    public function followers($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    //show followings
    public function following($id)
    {
        
        $user = $this->user->findOrFail($id);
        // dd($user->following->pluck('name'));
        return view('users.profile.following')->with('user', $user);
    }

    //update password
    public function updatePassword(Request $request)
    {
        // check if new_password_confirmation is the same as new_password
        // if (strcmp($request->get('new_password'), $request->get('new_password_confirmation')) !== 0) {
        //     return redirect()->back()->with('current_password_error', 'Your new password confirmation does not match with what you provided');
        // }
        /**
         * Step 1: check if current_password is the same as the password in the database
         * Step 2: check if current_password is the same as new_password
         * Step 3: validate the new_password
         * Step 4: update the password
         * Step 5: redirect back the user to the profile page with a success messageSte
         */

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect()->back()->with('current_password_error', 'Your current password does not match with what you provided');
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            return redirect()->back()->with('new_password_error', 'Your current password cannot be the same as your new password');
        }

        $request->validate([
            'current_password' => 'required|string|min:8|max:50',
            'new_password' => 'required|string|min:8|max:50|confirmed',
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        //

        $user->password = Hash::make($request->get('new_password'));

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id )->with('success_password', 'Your password has been updated successfully');
    }
}
