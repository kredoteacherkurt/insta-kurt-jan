@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8">
            {{-- POSTS --}}
            {{-- @forelse ($all_posts as $post) --}}
            @forelse ($home_posts as $post)
                <div class="card mb-4">
                    @include('users.posts.contents.title')
                    {{-- body --}}
                    @include('users.posts.contents.body')
                </div>
            @empty
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they will appear on your profile.</p>
                    <a href="{{ route('posts.create') }}" class="text-decoration-none">Share your first photo</a>
                </div>
            @endforelse
        </div>
        <div class="col-4 ">
           {{-- profile overview --}}
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                <div class="col-auto">
                    @if (auth()->user()->avatar)

                        {{-- <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle avatar-md"> --}}
                        <a href="{{ route('profile.show', auth()->user()->id) }}">
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle avatar-md">
                        </a>
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </div>
                <div class="col ps-0 text-truncate">
                    {{-- name --}}
                    <a href="{{ route('profile.show', auth()->user()->id) }}" class="text-decoration-none text-dark fw-bold">
                        {{ auth()->user()->name }}
                    </a>
                    {{-- email --}}
                    {{-- make email fit to screen --}}
                    <p class="text-secondary text-truncate" style="max-width: 200px;">
                        {{ auth()->user()->email }}</p>
                </div>
            </div>

           {{-- suggestion --}}
            @if ($suggested_users)
                <div class="row">
                    <div class="col-auto ">
                        <p class="fw-bold text-secondary">Suggestions For You</p>
                    </div>
                    <div class="col  text-end ">
                        <a href="{{ route('suggestions') }}" class="fw-bold text-dark text-decoration-none">See all</a>
                    </div>
                </div>
                
                @foreach ($suggested_users as $user)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('follow.store', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
