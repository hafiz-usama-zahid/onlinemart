<!DOCTYPE html>
<html>
<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
</style>
</head>
<body>

<div class="header">
  <a href="" class="logo">OnlineMart</a>
  <div class="header-right">
    <a class="active" href="http://127.0.0.1:8000/register">Register</a>
    <a href="http://127.0.0.1:8000/login">Log In</a>
    
  </div>
</div>
 {{-- {{ session()->get('user')->name }} --}}
  
</div>
</div>
<div class="sidebar">
    {{-- route for home page --}}
    <a  href="{{ route('home') }}">Home</a>
    {{-- route for categories records page --}}
    <a href="{{ route('categories.records') }}">Categories</a>
    {{-- route for products records page --}}
    <a href="{{ route('products.records') }}">Products</a>
    {{-- route for orders page --}}
    <a href="{{ route('orders') }}">Orders</a>
</div>

<div class="content">
  <div class="container">
    <div class="card">
      <div class="card-header"> <b>Add Category</b></div>
      <div class="card-body">
        {{-- for errors --}}
        
          <form action="{{ route('categories.post') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <label for="description" class="form-label">Category Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
            <label for="name" class="form-label">Category Image </label>
            <input type="file" class="form-control" id="image" name="image" required>

          </div>
          <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
