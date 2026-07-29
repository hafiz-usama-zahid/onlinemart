<style>
    .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: white;
    z-index: 1000;
    padding: 10px 25px; /* Slimmer height */
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', sans-serif;
}

.logo {
    font-size: 20px;
    font-weight: bold;
    text-decoration: none;
    color: white;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 12px; /* Closer spacing between buttons */
}

.header-right a {
    color: white;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 5px;
    transition: 0.3s ease;
}

.header-right a:hover {
    background: rgba(255, 255, 255, 0.15);
}

.header-right .btn {
    background: white;
    color: #007BFF;
    border: none;
    padding: 6px 14px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s ease;
}

.header-right .btn:hover {
    background: #f1f1f1;
}

body {
    padding-top: 65px; /* Adjust so content doesn't hide under header */
}


body {
    padding-top: 65px; /* Adjust so content doesn't hide under header */
}

</style>
<header class="site-header">
 <div class="header">
    <a href="{{ route('home') }}" class="logo">OnlineMart</a>
    
    <div class="header-right">
        @if (Session::has('user'))
            <a class="active" href="#">{{ session()->get('user')->name }}</a>
            <a href="{{ route('logout') }}" class="btn btn-light btn-sm">Logout</a>
        @else
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Log In</a>
        @endif
        
        <a href="{{ route('cart') }}" class="btn btn-light btn-sm">
            🛒 View Cart <strong> ({{ count(session('cart', [])) }})</strong>
        </a>
    </div>
</div>

</header>