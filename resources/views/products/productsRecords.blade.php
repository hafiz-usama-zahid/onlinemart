@extends('layout')
@section('section2')
<div class="container mt-5">
    <div class="container mt-4">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Product Records</h2>
        </div>
    <div class="d-flex justify-content-between mb-3">

        <span>
            <a href="{{ route('home') }}">
                <button class="btn btn-dark">Home</button>
            </a>
        </span>

        <span class="mb-3 text-end">
            
            <a href="{{ route('products') }}">
                <button class="btn btn-dark">Add New Product</button>
            </a>
        </span>
        </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        {{-- <a href="{{ route('products') }}" class="btn btn-success">Add New Product</a> --}}
    @endif
    <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                
                <td>
                    <center>
                        @if ($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" width="120" height="80" alt="Product Image">
                           @else
                           No Image
                           @endif
                        </center>
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{ route('products.delete', $product->id) }}" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
     </table>
     {{-- {{ $products->links() }} --}}
</div>
@endsection