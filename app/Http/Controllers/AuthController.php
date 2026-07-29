<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\login;
use App\Http\Requests\register;
use App\Http\Requests\DeliveryInformation;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Session;

class AuthController extends Controller
{
   
    //    Registration & Login Logic


    // Show registration form page
    public function register(){
        return view("auth.register");
    }

    // Handle registration form submission 
    public function registerPost(register $request){
            $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "user_type" => 'customer' // default type
        ]);

        // Check if user was created successfully
        // If user is created, store user information in session
        if ($user) {
            Session::put('user', $user);
            return redirect()->route("home")->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    // Show login form
    public function login(Request $request){
        return view("auth.login");
    }

    // Handle login form submission
    public function loginPost(Request $request){
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user', $user);
            return redirect('home');
        } elseif ($user) {
            return back()->with('fail', 'Incorrect password');
        } else {
            return back()->with('fail', 'This email is not registered');
        }
    }

    // User logout
    public function logout(){
        // Check if user is logged in
        if (Session::has('user')) {
            Session::pull('user');
            Session::pull('cart');
            return redirect()->route("home");
        }
        return redirect()->back()->with('error', 'User not logged in.');
    }

    
    // Show dashboard
    public function dashboard(Request $request){
        return view("auth.dashboard");
    }


    // Show home page
    public function home(Request $request){
        return view("auth.home");
    }
    

    
    // Show category form
    public function categories(Request $request){
        return view("categories.categories");
    }

    // Handle category form submission
   public function categoriesPost(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'description' => 'nullable|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        // Store in storage/app/public/categories
        $imagePath = $request->file('image')->store('categories', 'public');
    }

    $category = new Category();
    $category->name = $request->name;
    $category->description = $request->description;
    $category->image = $imagePath; // stored path
    $category->save();

    return redirect()->route('categories.records')->with('success', 'Category added successfully.');
    }



    // List all categories
    public function categoriesRecords(Request $request){
        $categories = Category::paginate(5);
        //show only avalible on records pages
        $currentPage = $request->input('page', 1);
        // Check if current page is valid
        if ($currentPage > $categories->lastPage()) {
            return redirect()->route('orders.records')->with('error', "Page = {$currentPage} does not exist. The last page number is {$categories->lastPage()}.");
        }
        return view("categories.categoriesRecords", compact('categories'));
    }

    // Show category edit form
    public function editCategory($id){
        $category = Category::findOrFail($id);
        return view('categories.editCategory', compact('category'));
    }

    // Update a category
    public function updateCategory(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Find the category by ID
        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }
        // Update other fields
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories.records')->with('success', 'Category updated successfully!');
    }

    // Delete a category
    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.records')->with('success', 'Category deleted successfully!');
    }

 
    //    Product Management
    

    // Show product form
    public function products(Request $request){
        $categories = Category::all();
        return view("products.products", compact('categories'));
    }

    // Handle product form submission
    public function productsPost(Request $request)
    {
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Store the data 
    $product = new Product();
    $product->name = $request->name;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->quantity = $request->quantity;

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->route('products.records')->with('success', 'Product added successfully.');
 }

    // List all products
    public function productsRecords (Request $request){
        $products = Product::with('category')->get();
        return view("products.productsRecords", compact('products'));
    }

    // Show product edit form
    public function editProduct($id){
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.editProduct', compact('product', 'categories'));
    }

    // Update a product
    public function updateProduct(Request $request, $id)
    {
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    $product = Product::findOrFail($id);

    // Update image if uploaded
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($product->image && file_exists(public_path('images/'.$product->image))) {
            unlink(public_path('images/'.$product->image));
        }

        // Store new image in public/images
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $product->image = $imageName;
    }

    // Update other fields
    $product->name = $request->name;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->category_id = $request->category_id;
    
    $product->save();

    return redirect()->route('products.records')->with('success', 'Product updated successfully!');
    }
    // Delete a product
    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.records')->with('success', 'Product deleted successfully!');
    }
    // Show product display page
    public function productDisplay()
    {
    $products = Product::with('category')->get(); 
    return view('auth.home', compact('products'));
    }

    //for display single product page/product details page
    public function product_details($id)
    {   
        $data = product::find($id);


        return view ('products.product_details' , compact('data'));
    }
}
