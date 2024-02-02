@extends('layouts.app')

@section('title', 'Create Post')

{{-- 
    
    Create the form for creating a new post.
    input:checkbox	name=“category[]”
    textarea		name=“description”
    input:file		name=“image”
    --}}
@section('content')
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">

        @csrf 
        {{-- 
            @csrf - Cross-Site Request Forgery
            It is a security measure to prevent attacks from malicious sites.
            --}}
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category
                <span class="text-muted fw-normal">(up to 3)</span>
            </label>
            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                        class="form-check-input">
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                </div>
            @endforeach
            {{-- error --}}
            @error('category')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
                
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3"
                class="form-control" placeholder="What's on your mind?">{{ old('description') }}</textarea>
            {{-- error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>
        <div class="mb-4">
            <label for="image" class="form-label fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
            <div id="image-info" class="form-text">
                The accepted formats are: jpg, jpeg, png, gif, svg. <br>
                Maximum size: 1048kB.
            </div>
            {{-- error --}}
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
@endsection
