{{-- Show a list of users who liked the post (Likes) --}}

<div class="modal fade" id="all-likes-post-{{ $post->id  }}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success justify-content-center">
                <h3 class="h5 modal-title text-dark" id="all-likes-post-{{ $post->id  }}">
                    <i class="fa-solid fa-heart text-danger"></i>
                    Likes
                </h3>
            </div>
            <hr class="m-0">
            {{-- get all the user_id from Likes and display the user's name in a list --}}
            <div class="modal-body justify-content-center">
                @if ($post->likes->count() > 0)
                    @foreach ($post->likes as $like)
                        <div class="row align-items-center mb-3">
                            <div class="col-6 text-end">
                                <a href="{{ route('profile.show', $like->user_id) }}" class="text-decoration-none">
                                    {{-- if the user has an avatar, display it, else display a default avatar --}}
                                    @if ($like->user->avatar)
                                        <img src="{{$like->user->avatar}}" alt="avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col-6 text-start">
                                <a href="{{ route('profile.show', $like->user_id) }}" class="text-decoration-none text-dark">
                                    {{ $like->user->name }}
                                </a>
                            </div>
                            
                        </div>
                    @endforeach
                @endif
            </div>
            
        </div>
    </div>
</div>