<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post'; // This is a Many to Many relationship. Laravel assumes that the table name is the plural form of the model name. In this case, the model name is CategoryPost. So, Laravel assumes that the table name is category_posts. But, we have a different table name. So, we need to specify the table name here.
    protected $fillable = ['post_id', 'category_id']; // We need to specify the fillable fields here. Otherwise, we will get a MassAssignmentException.
    public $timestamps = false; // We need to specify this because we don't have created_at and updated_at columns in this table.

    // get the name of the category of a post
    // RELATIONSHIP: A post belongs to a category. This is a 1 to Many (inverse) relationship.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
