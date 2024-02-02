@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
    {{-- 
        internal CSS : if in case the contents on the right side overflows. 
        If a post has many comments, the .card-body expands vertically, thus, the image container also expands. 
        This style declaration will fix that problem. Add it here since we only need this style in this page.
    --}}
    <style>
        .card-body {
            position: absolute;
            top: 65px;
        }
        .col-4 {
            overflow-y: scroll;
        }
    </style>
    <div class="row border shadow">
        
            {{-- <div class="px-0"> --}}
    
            <div class="col p-0">
                {{-- <div class="px-0"> --}}
                <img src="{{ $post->image }} " alt="post id {{ $post->id }}" class="w-100">
            </div>
            <div class="col-4 px-0 bg-white">
                {{-- <div class="px-0 bg-white"> --}}
                <div class="card border-0">
                    <div class="card-header bg-white py-3">
                        {{--  card-header here is similar to the homepage --}}
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                                    {{-- 
                                        if the user has an avatar, then show the avatar
                                        else, show the default avatar
                                        --}}
                                    @if ($post->user->avatar)
                                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0">
                                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                                    {{ $post->user->name }}
                                </a>
                            </div>
                            <div class="col-auto  ">
                                {{-- 
                                    if the user is the owner of the post, then show the dropdown menu
                                    else, do not show the dropdown menu
                                    --}}
                                @if (Auth::user()->id === $post->user->id)
                                    <div class="dropdown ">
                                        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item">
                                                {{-- 
                                                    route('posts.edit', $post->id) is the same as:
                                                    /posts/{post}/edit
                                                    --}}
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                                <i class="fa-regular fa-trash-can"></i>
                                                Delete
                                            </button>
                                        </div>
                                        {{-- include modal here --}}
                                        @include('users.posts.contents.modals.delete')
                                    </div>
                                @else
                                {{-- 
                                    if the user is not the owner of the post, then show unfollow button
                                    --}}

                                    {{-- <form action="{{ route('follow.store', $post->user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                            Follow
                                        </button>
                                    </form> --}}
                                    @if ($post->user->isFollowed())
                                        <form action="{{ route('follow.destroy', $post->user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                                Following
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $post->user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div> {{-- end of card header --}}
                    <div class="card-body w-100 bg-white">
                        {{-- HEart button + no. of likes + categoroes --}}
                        <div class="row align-items-center">
                            <div class="col-auto">
                                {{-- <form action="{{ route('like.store', $post->id) }}" method="POST">
                                        @csrf
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </form> --}}
                                @if ($post->isLiked())
                                    <form action="{{ route('like.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm shadow-none p-0">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('like.store', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm shadow-none p-0">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="col-auto px-0 ">
                                {{-- <span>{{ $post->likes->count() }}</span> --}}
                                <button class="btn btn-sm shadow-none p-0 fw-bold" data-bs-toggle="modal" data-bs-target="#all-likes-post-{{ $post->id  }}">
                                    <span>{{ $post->likes->count() }}</span>
                                </button>

                                @include('users.posts.contents.modals.likes')
                                

                            </div>
                            <div class="col text-end ">
                                {{-- 
                                    check if value is null
                                    if null, then show nothing
                                    else, show the categories
                                    [EDIT FROM ORIGINAL CODE] : added if statement to check if the post has categoriesPost 
                                    -this is to avoid error when the post has no categories
                                    --}}
                                {{-- @if ($post->categoryPost)
                                    @foreach ($post->categoryPost as $category_post)
                                        <div class="badge bg-secondary bg-opacity-50">
                                            {{ $category_post->category->name }}
                                        </div>
                                    @endforeach
                                @endif --}}
                                {{-- @foreach ($post->categoryPost as $category_post)
                                    <div class="badge bg-secondary bg-opacity-50">
                                        {{ $category_post->category->name }}
                                    </div>
                                @endforeach --}}
                                {{-- 
                                    this displays the categories of the post as badges
                                    --}}
                                @forelse ($post->categoryPost as $category_post)
                                    <span class="badge bg-secondary bg-opacity-50 text-decoration-none">
                                        {{ $category_post->category->name }}
                                    </span>
                                @empty
                                    <div class="badge bg-dark text-wrap">Uncategorized</div>
                                @endforelse
                            </div>
                        </div>
                        {{-- owner + description --}}
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                        &nbsp;
                        <p class="d-inline fw-light">
                            {{ $post->description }}
                        </p>
                        <p class="text-muted text-uppercase xsmall">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
        
                        {{-- comments --}}
                        <div class="mt-4 ">
                            {{-- Add a comment --}}
                            <form action="{{ route('comments.store', $post->id) }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <textarea 
                                        name="comment_body{{ $post->id }}"
                                        rows="1"
                                        class="form-control form-control-sm" 
                                        placeholder="Add a comment...">{{old('comment_body' . $post->id)}}</textarea>
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                                </div>
                                {{-- error --}}
                                @error('comment_body' . $post->id)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </form>
                        
                            {{-- Show all comments here --}}
                            @if ($post->comments->isNotEmpty())
                            {{-- <hr> --}}
                                <ul class="list-group mt-2 ">
                                    @forelse ($post->comments as $comment)
                                        <li class="list-group-item border-0 p-0 mb-2 bg-white">
                                            <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">
                                                {{ $comment->user->name }}
                                            </a>
                                            &nbsp;
                                            <p class="d-inline fw-light">{{ $comment->body }}</p>
                        
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
                                    
                                </ul>
                            @endif
                        </div> {{-- end of comments --}}
                    </div> {{-- end of card body --}}
                </div> {{-- end of card --}}
            </div> {{-- end of col --}}
        
    </div> {{-- end of row --}}
@endsection