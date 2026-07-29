<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>
    <body>
        {{-- User Navigation --}}
        <a  href="#">{{ session()->get('user')->name }}</a> 
        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        <div class="container"> <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
            @session("success")
            <div class="alert alert-success">{{ $value }}    
            </div>
            @endsession
            <h2>Hello, {{ session()->get('user')->name }}</h2>
            </div>
            </div>
            </div>
    </body>
</html>