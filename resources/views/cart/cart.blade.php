@extends('layout')

@section('section2')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">🛒 Your Shopping Cart</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th width="180">Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach(session('cart') as $id => $item)
                                @php 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                    $product = \App\Models\Product::find($id);
                                    $maxStock = $product ? $product->quantity : 1;
                                @endphp
                                <tr class="text-center" data-id="{{ $id }}" data-stock="{{ $maxStock }}">
                                    <td>{{ $item['name'] }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $item['image']) }}" width="60" height="60" class="rounded shadow-sm">
                                    </td>
                                    <td>Rs. {{ number_format($item['price'], 2) }}</td>

                                    <!-- Quantity Controls -->
                                    <td>
                                        <div class="input-group justify-content-center">
                                            <button class="btn btn-outline-secondary decrement-btn">-</button>
                                            <input type="number" 
                                                   class="form-control text-center quantity-input" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   max="{{ $maxStock }}" 
                                                   style="width: 60px;">
                                            <button class="btn btn-outline-secondary increment-btn">+</button>
                                        </div>
                                        <small class="text-muted d-block">Stock: {{ $maxStock }}</small>
                                    </td>

                                    <td class="fw-bold text-success subtotal">Rs. {{ number_format($subtotal, 2) }}</td>

                                    <!-- Remove Button -->
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-item">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0">
                    Total: <span class="text-success" id="cart-total">Rs. {{ number_format($total, 2) }}</span>
                </h4>
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">⬅ Continue Shopping</a>
                    <a href="{{ url('/checkout') }}" class="btn btn-success">Proceed to Checkout →</a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="text-muted">Your cart is empty </h4>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Shop Now</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    // Increment Quantity
    $(".increment-btn").click(function () {
        let row = $(this).closest("tr");
        let input = row.find(".quantity-input");
        let qty = parseInt(input.val()) || 1;
        let maxStock = parseInt(row.data("stock"));

        if (qty < maxStock) {
            input.val(qty + 1).trigger("change");
        } else {
            alert("Only " + maxStock + " items available in stock.");
        }
    });

    // Decrement Quantity
    $(".decrement-btn").click(function () {
        let row = $(this).closest("tr");
        let input = row.find(".quantity-input");
        let qty = parseInt(input.val()) || 1;

        if (qty > 1) {
            input.val(qty - 1).trigger("change");
        }
    });

    // Quantity Change (AJAX Update)
    $(".quantity-input").change(function () {
        let row = $(this).closest("tr");
        let id = row.data("id");
        let qty = parseInt($(this).val()) || 1;
        let maxStock = parseInt(row.data("stock"));

        if (qty > maxStock) qty = maxStock;
        if (qty < 1) qty = 1;

        $(this).val(qty);

        $.ajax({
            url: "{{ route('cart.update') }}", // ✅ Correct route
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                quantity: qty
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                }
            }
        });
    });

    // Remove Item
    $(".remove-item").click(function (e) {
        e.preventDefault();
        let row = $(this).closest("tr");
        let id = row.data("id");

        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function (res) {
                if (res.success) {
                    row.remove();
                    location.reload();
                }
            },
            error: function () {
                alert("Something went wrong!");
            }
        });
    });
});
</script>
@endsection
