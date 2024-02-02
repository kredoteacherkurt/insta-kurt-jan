@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">    
        <thead class="small table-success text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_posts as $post)
                <tr>
                    <td class="text-end">
                        {{ $post->id }}
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}">
                            <img src="{{ $post->image }}" alt="{{ $post->id }}" class="d-block mx-auto image-lg">
                        </a>
                    </td>
                    <td>
                        {{-- @foreach ($post->categoryPost as $category_post)
                            <span class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</span>
                        @endforeach --}}
                        @forelse ($post->categoryPost as $category_post)
                            <span class="badge bg-secondary bg-opacity-50 text-decoration-none">
                                {{ $category_post->category->name }}
                            </span>
                        @empty
                            <div class="badge bg-dark text-wrap">Uncategorized</div>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                            {{ $post->user->name }}
                        </a>
                    </td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>
                        {{-- <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible --}}
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle text-secondary"></i>&nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i> 
                            </button>
                            {{-- <div class="dropdown-menu">
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                    <i class="fa-solid fa-eye-slash"></i>
                                    Hide Post {{ $post->id }}
                                </button>
                            </div> --}}
                            @if ($post->trashed())
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                        Unhide Post {{ $post->id }}
                                    </button>
                                </div>
                            @else
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i>
                                        Hide Post {{ $post->id }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        {{-- Include the modal here --}}
                        @include('admin.posts.modal.status')
                    </td>
                </tr>
               
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        <h4 class="text-secondary">No posts found</h4>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
    </div>
@endsection