@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="row gx-2 mb-4">
            <div class="col-10">
                <input type="text" name="name" id="name" class="form-control" placeholder="Add a category..." autofocus>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add
                </button>
            </div>
            {{-- error --}}
            @error('name')
                {{-- <div class="col-12"> --}}
                    <p class="text-danger small">{{ $message }}</p>
                {{-- </div> --}}
            @enderror
        </div>
    </form>
    <div class="row">
        <div class="col">
            <table class="table table-hover align-middle bg-white border table-sm text-secondary text-center">
                <thead class="table-warning small text-secondary">
                    <th>#</th>
                    <th>NAME</th>
                    <th>COUNT</th>
                    <th>LAST UPDATED</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($all_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="text-dark">{{ $category->name }}</td>
                            <td>{{ $category->categoryPost->count() }}</td>
                            <td>
                                @if ($category->updated_at)
                                    {{ $category->updated_at->diffForHumans() }}
                                @elseif ($category->updated_at == null)
                                    @if ($category->created_at)
                                        {{ $category->created_at->diffForHumans() }}
                                    @else
                                        {{-- display message date not found --}}
                                        <p class="text-danger small">Date not found.</p>
                                    @endif
                                @endif      
                            </td>
                            <td>
                                {{-- edit button --}}
                                <button class="btn btn-sm btn-outline-warning me-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#edit-category-{{ $category->id }}"
                                    title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                {{-- delete button --}}
                                <button class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#delete-category-{{ $category->id }}"
                                    title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        {{-- edit modal --}}
                        {{-- delete modal --}}
                        @include('admin.categories.modal.action')
                    @empty
                        <tr>
                            <td colspan="5" class="lead text-muted text-center">No categories found.</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td></td>
                        <td class="text-dark">
                            Uncategorized
                            <p class="xsmall mb-0 text-muted">Hidden posts are not included.</p>
                        </td>
                        <td class="text-dark fw-bold text-center small">
                            {{ $uncategorized_count }}
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            {{-- pagination --}}
            <div class="d-flex justify-content-center">
                {{ $all_categories->links() }}

            </div>
        </div>
    </div>
@endsection