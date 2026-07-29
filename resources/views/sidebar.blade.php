<style>
    /* vvv */
   .sidebar {
    position: fixed;
    top: 65px; /* same as header height */
    left: 0;
    width: 200px;
    height: calc(100% - 65px);
    background: linear-gradient(to right, #1F2937, #374151); /* match header gradient if any */
    color: white;
    padding-top: 15px;
    font-family: 'Segoe UI', sans-serif;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15); /* match header shadow */
    border-right: 1px solid rgba(255,255,255,0.1); /* subtle separation */
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: background 0.3s ease, padding-left 0.3s ease;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.1);
    padding-left: 25px;
}


    </style>
<div class="sidebar">
    {{-- route for home page --}}
    <a  href="{{ route('home') }}">Home</a>
    @if(session()->exists('user') && (session()->get('user')->user_type == 'admin'))
    {{-- route for categories records page --}}
    <a href="{{ route('categories.records') }}">Categories</a>
    {{-- route for products records page --}}
    <a href="{{ route('products.records') }}">Products</a>
    @endif
    {{-- route for orders page --}}
    <a href="{{ route('orders') }}">Orders</a>
</div>


                    