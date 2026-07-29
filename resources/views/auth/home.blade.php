<style>
    .btn-custom {
    background: linear-gradient(to right, #007bff, #00c6ff); /* same as header */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-custom:hover {
    opacity: 0.9;  
}

    </style>
@extends('layout')

@section('section2')


    <h2 class="mt-4 mb-3">Our Products</h2>


    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 w-10">
                    @if($product->image)
                    <center>
                        <img src="{{ asset('images/' . $product->image) }}" width="234" height="250" alt="Product Image">
                    </center>
                     @else
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Price:</strong> Rs. {{ $product->price }}</p>
                    <p class="card-title"><strong>Avaliable Quantity: </strong>{{ $product->quantity }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>

                    {{-- <label for="Quantity">Quantity</label> --}}
                    <div class="quantity-container input-group text-center mb3" style="width:80px;">
                    
                   </div>
                </div>
                    
                    <a class="btn-custom" href="{{ url('product_details',$product->id) }}">Details</a>
                    
                    
                        
                </div>
            </div>
        @endforeach
    </div>
@endsection

