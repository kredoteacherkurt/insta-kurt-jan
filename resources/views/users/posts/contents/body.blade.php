{{-- clickable iamge --}}
<div class="container p-0">
    <a href="{{ route('posts.show', $post->id) }}">
        {{-- image --}}
        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
    </a>
</div>
{{-- like + comment + share --}}
<div class="card-body bg-white">
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
        <div class="col-auto px-0">
            {{-- <span>{{ $post->likes->count() }}</span> --}}
            <button class="btn btn-sm shadow-none p-0 fw-bold" data-bs-toggle="modal" data-bs-target="#all-likes-post-{{ $post->id  }}">
                <span>{{ $post->likes->count() }}</span>
            </button>

            @include('users.posts.contents.modals.likes')
        </div>
        <div class="col text-end">
            {{-- @foreach ($post->categoryPost as $category_post)
                <a href="#" class="badge bg-secondary bg-opacity-50 text-decoration-none">
                    {{ $category_post->category->name }}
                </a>
            @endforeach --}}
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
    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
        {{ $post->user->name }} 
    </a>
    &nbsp;
    <p class="d-inline fw-light">
        {{ $post->description }}
    </p>
    <p class="text-muted text-uppercase xsmall">
        {{ $post->created_at->diffForHumans() }}
        {{-- 
            diffForHumans() is a method from Carbon\Carbon 
            it will return the time difference between the post created_at and now
            example: 1 hour ago, 2 days ago, 1 month ago, etc
            --}}
    </p>

    {{-- comments --}}
    @include('users.posts.contents.comments')
    
</div>