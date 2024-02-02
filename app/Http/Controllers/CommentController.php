<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    // store
    public function store(Request $request,$post_id)
    {
        // $request->validate([
        //     'comment_body' . $post_id => 'required|string|min:1|max:150'
        // ]);

        // Modify the error message in the store method.
        $request->validate([
            'comment_body' . $post_id => 'required|max:150'
        ], [
            'comment_body' . $post_id . '.required' => 'Cannot submit an empty comment.',
            // 'comment_body' . $post_id . '.string' => 'The comment must be a string.',
            // 'comment_body' . $post_id . '.min' => 'The comment must be at least :min characters.',
            'comment_body' . $post_id . '.max' => 'The comment may not be greater than :max characters.'
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->body = $request->input('comment_body' . $post_id);
        $this->comment->save();

        return redirect()->back();

        
    }

    // destroy
    public function destroy($id)
    {
        $this->comment->destroy($id);
        return redirect()->back();
    }
}
