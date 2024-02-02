<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    // show all categories
    public function index(){
        // [1] get all categories
        // $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(8);
        // return view('admin.categories.index')->with('all_categories', $all_categories);

        // [2] get all categories and count the number of posts in each category
        // $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(8);
        // $updated_at = $this->category->updated_at;
        //check if updated_at is null, if it is null then do not use orderBy
        // if ($updated_at == null){
            // $all_categories = $this->category->paginate(8);
        // }else{
            // $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(8);
        // }

        $all_categories = $this->category->orderBy('updated_at', 'desc')->paginate(8);

        $uncategorized_count = 0;
        $all_posts = $this->post->all(); 
        foreach($all_posts as $post){
            if ($post->categoryPost->count() == 0){
                $uncategorized_count++;
            }
        }

        return view('admin.categories.index')->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);


    }

    //store category
    public function store(Request $request){
        // [1] validate data
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name',
        ]);
        // [2] store data . 
        // use ucwords to capitalize the first letter of each word 
        // and strtolower to convert the string to lowercase
        $this->category->name = ucwords(strtolower($request->name));
        $this->category->save();
        // [3] return to index page
        return redirect()->back();
    }

    //update category
    public function update(Request $request, $id){
        // [1] validate data
        $request->validate([
            'new_name' => 'required|min:1|max:50|unique:categories,name,'.$id,
        ]);
        // [2] update data
        $this->category = $this->category->findOrFail($id);
        $this->category->name = ucwords(strtolower($request->new_name));
        $this->category->save();
        // [3] return to index page
        return redirect()->back();
    }

    //delete category
    public function destroy($id){
        // [1] delete data
        $this->category->destroy($id);
        // [2] return to index page
        return redirect()->back();
    }
}
