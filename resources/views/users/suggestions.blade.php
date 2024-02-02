@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    {{-- @include('users.profile.header') --}}

    {{-- Show a full-page list of suggested users (users that you are not following --}}

    <div class="col-lg-6 col-md-10 mx-auto">
        {{-- profile overview --}}
        @if ($suggested_users)
                <div class="row">
                    <div class="col-auto">
                        <p class="fw-bold text-secondary">Suggested</p>
                    </div>
                    {{-- <div class="col text-end">
                        <a href="#" class="fw-bold text-dark text-decoration-none">See all</a>
                    </div> --}}
                </div>
                
                @foreach ($suggested_users as $user)
                    <div class="row align-items-center mb-3">
                        <div class="col-4 col-md-2">
                            {{-- <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md"> --}}
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col-auto">
                            
                            {{-- name --}}
                            {{-- <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a> --}}
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                                    {{ $user->name }}
                                </a>
                            </div>
                            {{-- email --}}
                            {{-- <p class="text-secondary">{{ $user->email }}</p> --}}
                            <div class="col-auto">
                                {{ $user->email }}
                            </div>
                            {{-- number of followers --}}
                            {{-- <p class="text-secondary  xsmall">{{ $user->followers->count() }} followers</p> --}}
                            <div class="d-flex align-items-center xsmall">
                                @if ($user->isFollowing())
                                    <p>Follows you</p>
                                @else
                                    <p>{{ $user->followers->count() }} followers</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col text-end">
                            <form action="{{ route('follow.store', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
    </div>
    
@endsection