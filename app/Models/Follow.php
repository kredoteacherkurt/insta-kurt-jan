<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    // To get the names of the followers on the previous relationship, define the inverse. A follower is a user
    // RELATIONSHIP: A follower is a user. This is a 1 to Many (inverse) relationship.
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }

    //To get the info of the user being followed.
    // RELATIONSHIP: A user is being followed. This is a 1 to Many (inverse) relationship.
    public function following()
    {
        // return $this->belongsTo(User::class, 'following_id');
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class)->withTrashed();
        
    }
}
