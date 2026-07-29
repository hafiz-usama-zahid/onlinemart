@extends('layout')
@section('section2')  

@if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
    @endif
<div class="container mt-10">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Categories Records</h2>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
        
        <span>
            <a href="{{ route('home') }}">
                <button class="btn btn-dark">Home</button>
            </a>
        </span>
        
        <span class="mb-3 text-end">
            
            <a href="{{ route('categories') }}">
                <button class="btn btn-dark">Add New Category</button>
            </a>
        </span>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    
    <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?? '---' }}</td>
                <td>
                    <center>
                        @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" width="120" height="80" alt="Category Image">
                        @else
                        No Image
                        @endif
                           </center>
                        </td>

                        <td>{{ $category->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            {{-- <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $category->id }})">Delete</button> --}}
                            <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
        </table>
        {{ $categories->links() }}
    </div>
    @endsection