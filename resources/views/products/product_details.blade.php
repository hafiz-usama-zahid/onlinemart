@extends('layout')

@section('section2')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center">Our Products</h2>

    <div class="row justify-content-center">
        <span>
            <a href="{{ route('home') }}">
                <button class="btn btn-dark">Home</button>
            </a>
        </span>
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 rounded-3 p-3 product-card d-flex flex-row align-items-center">

                {{-- Left: Product Image --}}
                @if($data->image)
                    <img src="{{ asset('images/' . $data->image) }}" 
                         class="rounded me-4" 
                         style="width: 280px; height: 280px; object-fit: cover;" 
                         alt="{{ $data->name }}">
                @else
                    <img src="https://via.placeholder.com/180" 
                         class="rounded me-4" 
                         style="width: 180px; height: 180px; object-fit: cover;" 
                         alt="No Image">
                @endif

                {{-- Right: Product Info --}}
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-1">{{ $data->name }}</h4>
                    <p class="mb-1 text-muted"><strong>Price:</strong> Rs. {{ $data->price }}</p>

                    {{-- Stock Badge --}}
                    @if($data->quantity > 0)
                        <span class="badge bg-success mb-2">In Stock ({{ $data->quantity }})</span>
                    @else
                        <span class="badge bg-danger mb-2">Out of Stock</span>
                    @endif

                    <p class="text-muted"><strong>Category:</strong> {{ $data->category->name ?? 'N/A' }}</p>
                    
                    {{-- Add to Cart Button --}}
                    @if(session()->exists('user') && (session()->get('user')->user_type != 'admin'))
                    <a href="{{ route('add.to.cart', $data->id) }}" 
                        class="btn btn-primary mt-2 rounded-pill {{ $data->quantity <= 0 ? 'disabled' : '' }}">
                        <i class="fa fa-cart-plus"></i> Add to Cart
                    </a>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>

{{-- Hover Effect --}}
<style>
.product-card {
    transition: transform 0.3s ease-in-out;
}
.product-card:hover {
    transform: translateY(-41px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
</style>
@endsection
