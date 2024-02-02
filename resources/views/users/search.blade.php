@extends('layouts.app')

@section('title', 'Explore People')

@section('content')
    <div class="row justify-content-center">
        <div class="col-auto">
            <p class="h5 text-muted mb-4"> Search result for "<span class="fw-bold">{{ $search }}</span>"</p>
        </div>
        @forelse ($users as $user)
            {{-- make the div below align with center like the above div --}}
            <div class="row  align-items-center mb-3">
                <div class="col-4 text-end">
                   <a href="{{ route('profile.show', $user->id) }}">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col-4 ps-0 text-truncate">
                   
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                        {{ $user->name }}
                    </a>
                    <p class="text-secondary text-truncate" style="max-width: 200px;">
                        {{ $user->email }}</p>
                </div>
                <div class="col-auto text-start">
                    @if (Auth::user()->id !== $user->id)
                        @if ($user->isFollowed())
                            <form action="{{ route('follow.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                            </form>
                        @else
                            <form action="{{ route('follow.store', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary fw-bold btn-sm fw-bold">Follow</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            {{-- <div class="col-5"> --}}
                <p class="lead text-muted text-center">No users found.</p>
            {{-- </div> --}}
        @endforelse
    </div>
@endsection