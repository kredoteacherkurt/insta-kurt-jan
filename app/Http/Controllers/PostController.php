<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    // create
    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048'
        ]);

        $this->post->user_id = Auth::user()->id;
        /**
         * data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACt...
         * format: data:image/[image extension];base64, [base64 encoded image]
         * the base64 encoded image is the image itself
         * 
         * base64_encode(file_get_contents($request->image)) returns the base64 encoded image
         */
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        // save the categories
        // foreach ($request->category as $category) {
        //     $this->post->categoryPost()->create([
        //         'category_id' => $category,
        //         'post_id' => $this->post->id
        //     ]);
        // }
        // [option 1]
        // foreach ($request->category as $category_id) {
        //     $category_post = [
        //         'category_id' => $category_id,
        //         'post_id' => $this->post->id                // UDATED S'KYLE CODE
        //     ];
        // }
        // $this->post->categoryPost()->createMany($category_post);
        // [option 2]
        foreach ($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id,
                'post_id' => $this->post->id
            ];
        }
        $this->post->categoryPost()->createMany($category_post);



        /**
         * explanation of the above code:
         * Loop through an array of categories and create a new category_post record for each category.
         * It is a Many to Many relationship, so we need to create a new record in the category_post table.
         * createMany() method is used to create multiple records at once.
         * 2D array is passed to createMany() method.
         * example of 2D array:
         * [
         *     ['category_id' => 1, 'post_id' => 1],
         *    ['category_id' => 2, 'post_id' => 1],
         * ]
         */

        return redirect()->route('index');
    }

    // show
    public function show($id)
    {
        $post = $this->post->findOrfail($id);
        return view('users.posts.show')->with('post', $post);
    }

    // edit
    public function edit($id)
    {
        
        $post = $this->post->findOrfail($id);

        //if user is not the owner of the post, redirect to index page
        if ($post->user_id != Auth::user()->id) {
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();

        // get all the categories of the post
        $selected_categories = [];
        foreach ($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    // update
    public function update(Request $request, $id) 
    {
        //validate the request
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048'
        ]);

        // get the post
        $post = $this->post->findOrfail($id);

        //get the description from the request 
        $post->description = $request->description;

        // if user uploaded a new image, update the image
        if ($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        // delete all the records from category_post table for this post
        $post->categoryPost()->delete();

        // save the categories
        foreach ($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id,
                'post_id' => $post->id
            ];
        }

        $post->categoryPost()->createMany($category_post);

        // this redirect is not working
        // return redirect()->route('index');
        // redirect to the show page of the post
        return redirect()->route('posts.show', $post->id);
    }

    // delete
    public function destroy($id)
    {
        $post = $this->post->findOrfail($id);

        //if user is not the owner of the post, redirect to index page
        if ($post->user_id != Auth::user()->id) {
            return redirect()->route('index');
        }

        $post->delete();
        return redirect()->route('index');
    }

    
}
