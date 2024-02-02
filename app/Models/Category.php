<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Get the posts of a category
    // RELATIONSHIP: A category has many posts. This is a 1 to Many relationship.
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }
}
