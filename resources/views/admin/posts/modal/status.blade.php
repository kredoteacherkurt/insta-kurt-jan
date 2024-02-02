@if ($post->trashed())
    {{-- Unhide --}}
    <div class="modal fade" id="unhide-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header border-success">
                    <h3 class="h5 modal-title text-success">
                        <i class="fa-solid fa-user"></i>
                        Unhide Post
                    </h3>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to unhide <span class="fw-bold">{{ $post->title }}</span>?
                    </p>
                    <div class="mt-3">
                        <img src="{{$post->image}}" alt="post id {{ $post->title }}" class="image-lg">
                        <p class="mt-1 text-muted">
                            {{ $post->description }}
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.unhide', $post->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            Unhide
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@else
    {{-- Hide --}}
    <div class="modal fade" id="hide-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header border-danger">
                    <h3 class="h5 modal-title text-danger">
                        <i class="fa-solid fa-user-slash"></i>
                        Hide Post
                    </h3>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to hide <span class="fw-bold">{{ $post->title }}</span>?
                    </p>
                    <div class="mt-3">
                        <img src="{{$post->image}}" alt="post id {{ $post->title }}" class="image-lg">
                        <p class="mt-1 text-muted">
                            {{ $post->description }}
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.hide', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger btn-sm">
                            Hide
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

