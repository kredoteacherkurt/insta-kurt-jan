<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user has many posts. This is a 1 to Many relationship.
    // RELATIONSHIP: A user has many posts. This is a 1 to Many relationship.
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    // A user has many followers. This is a 1 to Many relationship.
    // RELATIONSHIP: A user has many followers. This is a 1 to Many relationship.
    // To get the followers, we can select the following_id column from the Follow model.
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // A user can follow many users. This is another One-to-Many relationship.
    // RELATIONSHIP: A user can follow many users. This is another One-to-Many relationship.

    public function following()
    {
        // return $this->hasMany(Follow::class, 'follower_id');
        return $this->hasMany(Follow::class, 'follower_id');
    }

    //In the User model (User.php), let’s create a method that will return TRUE if the Auth user is following a user
    // RELATIONSHIP: A user can follow many users. This is another One-to-Many relationship.
    public function isFollowed() {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }

     // to check if the user is following the login user
     public function isFollowing() {
        return $this->following()->where('following_id', Auth::user()->id)->exists();
    }
   
}
