<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // A post belongs to a user. This is a 1 to Many (inverse) relationship.
    // RELATIONSHIP: A post belongs to a user. This is a 1 to Many (inverse) relationship.
    // This is to access the foreign key user_id in the posts table and the primary key id in the users table.
    // The belongsTo() method is used to define the inverse of a one-to-many relationship.
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // Get the categories of a post
    // RELATIONSHIP: A post belongs to many categories. This is a Many to Many relationship.
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    // Get the comments of a post
    // RELATIONSHIP: A post has many comments. This is a 1 to Many relationship.
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    // Get the likes of a post
    // RELATIONSHIP: A post has many likes. This is a 1 to Many relationship.
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // a method that will return TRUE if the user already liked the post, FALSE otherwise
    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

}
