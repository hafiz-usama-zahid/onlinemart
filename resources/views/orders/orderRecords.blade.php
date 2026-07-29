@extends('layout')
@section('section2')
    @if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
    @endif
    <div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">All Orders</h2>

    @if($orders->count() > 0)
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Order#</th>
                        <th>User Name</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Address</th>
                        <th>Print Bill</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through each order --}}
                    @foreach($orders as $order)
                        <tr class="text-center">
                            {{-- <td>{{ $loop->index + 736411 + 1 }}</td> --}}

                            {{-- <td>{{$order->orderno}}</td> --}}
                            <td>{{$order->orderno}}</td>
                            <td>{{ $order->user?->name }}</td>
                            <td>Rs. {{ number_format($order->amount, 2) }}</td>
                             @if(session()->exists('user') && (session()->get('user')->user_type == 'admin'))

                                {{--  dropdown for status --}}
                                <td>
                                
                                <select class="order-status" data-order-id="{{ $order->id }}">
                                        <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Processing</option>
                                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Shipped</option>
                                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Delivered</option>
                                        <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Cancelled</option>
                                        <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>Completed</option>
                                </select>

                            </td>
                            @else 
                            <td>
                                    @if($order->status == 0)
                                        Pending
                                    @elseif($order->status == 1)
                                        Processing
                                    @elseif($order->status == 2)
                                        Shipped
                                    @elseif($order->status == 3)
                                        Delivered
                                    @elseif($order->status == 4)
                                        Cancelled
                                    @elseif($order->status == 5)
                                        Completed    
                                    @else
                                        Unknown
                                    @endif
                            </td>
                            @endif
                            <td>{{ $order->created_at->setTimezone('Asia/Karachi')->format('d M Y h:i A') }}</td>
                            <td>
                                <ul class="list-group mb-3">
                                        @foreach($order->orderProducts as $product)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                         <strong>{{ $product->product->name ?? 'Unknown Product' }}</strong><br>
                                                            <small class="text-muted">
                                                                {{ $product->quantity }} X Rs. {{ number_format($product->price, 2) }}
                                                            </small>
                                                    </div>
                                                         <span class="badge bg-success rounded-pill">
                                                            Rs. {{ number_format($product->quantity * $product->price, 2) }}
                                                        </span>
                                                </li>
                                        @endforeach
                                </ul>
                            </td>
                           <td> <a href="{{ route('orders.delivery', $order->id) }}" class="btn btn-secondary">CLICK</a></td>
                           <td>
                             {{-- <a  class="btn btn-primary " href="{{ url('print_pdf' ,$order->id) }}"><center>PRINT PDF</center></a></td> --}}
                             <a href="{{ route('print_pdf', $order->id) }}" target="_blank" class="btn btn-primary">Print PDF</a>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="text-muted">No orders found </h4>
        </div>
    @endif
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('change', '.order-status', function () {
    let orderId = $(this).data('order-id');
    let status = $(this).val();

    $.ajax({
        url: "{{ route('orders.updateStatus') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            order_id: orderId,
            status: status
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
            }
        },
        error: function (xhr) {
            alert("Failed to update status!");
        }
    });
});
</script>

