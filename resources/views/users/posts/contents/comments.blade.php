<div class="mt-3">
    {{-- Show all comments here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group bg-white">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2 bg-white">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">
                        {{-- 
                            if the user has a profile image, then show it
                            else, show the default image
                            --}}
                        {{ $comment->user->name }}
                    </a>
                    &nbsp;
                    <p class="d-inline fw-light">
                        {{ $comment->body }}
                    </p>

                    {{-- delete comment --}}
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                        {{-- 
                            csrf protection
                            https://laravel.com/docs/8.x/csrf
                            --}}
                        @csrf
                        @method('DELETE')
                        {{-- created at --}}
                        <span class="text-muted text-uppercase xsmall">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>

                        {{-- 
                            if the user is the owner of the comment, then show the delete button
                            --}}
                        @if (Auth::user()->id === $comment->user->id)
                            {{-- 
                                middot as interpunct (·)
                                - middle dot
                                https://en.wikipedia.org/wiki/Interpunct
                                &middot;
                                --}}
                            &middot;
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">
                                Delete
                            </button>
                        @endif
                    </form>
                </li>
            @endforeach
            {{-- 
                if the comments are more than 3, then show the button to show more comments
                --}}
            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0 bg-white">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none small">
                        View all {{ $post->comments->count() }} comments
                    </a>
                </li>
            @endif
        </ul>
    @endif



    {{-- Add a comment --}}
    <form action="{{ route('comments.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group">
            {{-- 
                note: do not place {{ old('comment_body') }} in a new line because it will create a new line in the textarea
                --}}
            <textarea 
                name="comment_body{{ $post->id }}"
                rows="1"
                class="form-control form-control-sm" 
                placeholder="Add a comment...">{{old('comment_body'.$post->id)}}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        {{-- error --}}
        @error('comment_body' . $post->id)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </form>
</div>