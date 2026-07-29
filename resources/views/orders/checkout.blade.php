@extends('layout')

@section('section2')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center text-primary">🛒 Checkout</h2>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Left Column: Delivery Information --}}
            <div class="col-lg-8">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white fw-bold">
                        Delivery Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control"  placeholder="Enter your complete name">
                            </div>
                            @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                            <div class="col-md-6">
                                <label for="province" class="form-label">Province</label>
                                <input type="text" name="province" id="province" class="form-control"  placeholder="Please enter your province">
                            </div>
                            @error('province')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control"  placeholder="Please enter your phone number">
                            </div>
                            @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control"  placeholder="Please enter your city">
                            </div>
                            @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                            <div class="col-md-6">
                                <label for="building" class="form-label">Building / House / Street</label>
                                <input type="text" name="building" id="building" class="form-control"  placeholder="Please enter">
                            </div>
                            @error('building')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                            <div class="col-md-6">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" name="area" id="area" class="form-control"  placeholder="Please enter your area">
                            </div>
                            @error('area')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control"  placeholder="For Example: House# 123, Street# 12, ABC Road">
                            </div>
                            @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-secondary text-white fw-bold">
                        Order Summary
                    </div>
                    <div class="card-body">
                        @php $total = 0; @endphp
                        <ul class="list-group mb-3">
                            @foreach(session('cart', []) as $item)
                                @php 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $item['name'] }}</strong><br>
                                        <small class="text-muted">{{ $item['quantity'] }} x Rs. {{ $item['price'] }}</small>
                                    </div>
                                    <span>Rs. {{ number_format($subtotal, 2) }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span>Rs. {{ number_format($total, 2) }}</span>
                            </li>
                        </ul>

                        <button type="submit" class="btn btn-success w-100 fw-bold">Place Order</button>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/cart') }}" class="btn btn-outline-secondary btn-sm">← Back to Cart</a>
                    <a href="{{ url('/home') }}" class="btn btn-outline-primary btn-sm">Continue Shopping →</a>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    .form-label {
        font-weight: 600;
    }
    input::placeholder {
        font-size: 0.9rem;
        color: #aaa;
    }
</style>


@endsection
