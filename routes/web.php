<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AlreadyloggedIn;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;



// Route::get('/home', function () {
//     return view('/');
// });


// // This route displays the home page
// Route::get("/", [AuthController::class, "index"])->name('home');

// This route displays home page in which products are displayed
Route::get("home", [AuthController::class, "productDisplay"])->name("home");
//for display single product page/product details page
route::get('product_details/{id}',[AuthController::class,'product_details']);

//middle ware logics
Route::group(['middleware'=>'is_admin'],function(){

   //Authentication & User Routes


// Show registration form
Route::get("register", [AuthController::class, "register"])->name("register");

// Handle registration form submission
Route::post("register", [AuthController::class, "registerPost"])->name("register.post");

// Show login form
Route::get("login", [AuthController::class, "login"])->name("login");

// Handle login form submission
Route::post("login", [AuthController::class, "loginPost"])->name("login.post");


});

Route::middleware(['check.expiry'])->group(function () {
    Route::get('/', fn () => view('welcome'));
    
    Route::group(['middleware'=>'is_login'],function(){
// Routes


// Logout route
Route::get("logout", [AuthController::class, "logout"])->name("logout");

// User dashboard page
Route::get("dashboard", [AuthController::class, "dashboard"])->name("dashboard");


//route for admin
// Route::group(['middleware'=>'is_admin'],function(){
   
// Show category creation form
Route::get("categories", [AuthController::class, "categories"])->name("categories");

// Handle category creation form submission
Route::post("categories", [AuthController::class, "categoriesPost"])->name("categories.post");

// View all categories from DB
Route::get("categoriesRecords", [AuthController::class, "categoriesRecords"])->name("categories.records");

// Delete a category
Route::get('categories/delete/{id}', [AuthController::class, 'deleteCategory'])->name('categories.delete');

// Show edit form for a category
Route::get('categories/edit/{id}', [AuthController::class, 'editCategory'])->name('categories.edit');

// Update a category
Route::post('categories/update/{id}', [AuthController::class, 'updateCategory'])->name('categories.update');


//    Product Routes


// Show product creation form
Route::get('/products', [AuthController::class, 'products'])->name('products');

// Handle product creation form submission
Route::post('/products', [AuthController::class, 'productsPost'])->name('products.post');

// Display all product records
Route::get('/products/records', [AuthController::class, 'productsRecords'])->name('products.records');

// Show product edit form
Route::get('/products/edit/{id}', [AuthController::class, 'editProduct'])->name('products.edit');

// Handle product update submission
Route::post('/products/update/{id}', [AuthController::class, 'updateProduct'])->name('products.update');

// Delete a product
Route::get('/products/delete/{id}', [AuthController::class, 'deleteProduct'])->name('products.delete');


// });



//route for add to  cart
Route::get('/add-to-cart/{id}',[CartController::class, 'addToCart'])->name('add.to.cart');
//route for add to  cart page
Route::get('/cart',[CartController::class, 'cart'])->name('cart');
//route for update cart product quantity
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
//route for remove product from cart
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
//route for checkout page
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.get');
//route for place order
Route::post('/checkout/place', [CartController::class, 'placeOrder'])->name('checkout.place');


// route for checkout page
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.get');
// route for place order
//Route::post('/checkout/place', [CartController::class, 'placeOrder'])->name('checkout.place');
Route::post('/checkout/place', [CartController::class, 'placeOrder'])->middleware('is_login')->name('checkout.place');
// route for place order
Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.placeOrder');
//route for all orders
Route::get('/orders', [CartController::class, 'allOrders'])->name('orders');
//for delivery 
Route::get('/delivery/{id}', [CartController::class, 'delivery'])->name('orders.delivery');

//route to update the order status
Route::post('/orders/update-status', [CartController::class, 'updateStatus'])->name('orders.updateStatus');


//route for pdf
Route::get('print_pdf/{id}', [CartController::class, 'print_pdf'])->name('print_pdf');


});

});