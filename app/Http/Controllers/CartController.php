<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeliveryInformation;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class CartController extends Controller
{
    // Add to Cart
    public function addToCart($id, Request $request)
    {
    $product = Product::findOrFail($id);

    $cart = session('cart', []);

    // Check current quantity in cart
    $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;

    // Check if stock is available
    if ($currentQty + 1 > $product->quantity) {
        return redirect()->back()->with('error', 'Only ' . $product->quantity . ' items available in stock.');
    }

    // Add or increment product
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Product added to cart.');
    }


    //  Show Cart Page
    public function cart()
    {
        $cart = session('cart', []);
        return view('cart.cart', compact('cart'));
    }

    // 3 Update Quantity
    public function update(Request $request)
    {
        $cart = session('cart', []);
        if (isset($cart[$request->id])) {
            // Update quantity
            $cart[$request->id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }
        // Return success response
        return response()->json(['success' => true]);
    }

    // 4 Remove from Cart
    public function remove(Request $request)
    {
    $cart = session('cart', []);
    if (isset($cart[$request->id])) {
        unset($cart[$request->id]);
        session(['cart' => $cart]);
    }
    return response()->json(['success' => true]);
    }

    // 5 Checkout Page
    public function checkout(Request $request)
    {
        return view('orders.checkout');
    }

    public function placeOrder(DeliveryInformation $request)
    {
        
        // Prevent admin from placing orders
        if (session()->get('user')->user_type === 'admin') {
        return redirect()->back()->with('error', 'Admins are not allowed to place orders.');
        }

        try{
            DB::beginTransaction();
            $cart = session('cart', []);

            if (empty($cart)) {
                return redirect()->back()->with('error', 'Your cart is empty!');
            }

            $totalAmount = 0;
            // Check stock availability
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);

                if ($item['quantity'] > $product->quantity) {
                    return redirect()->back()->with('error', "Not enough stock for {$product->name}. Available: {$product->quantity}");
                }

                $totalAmount += $item['price'] * $item['quantity'];
            }
            $latestOldOrder = Order::latest()->first();
            if($latestOldOrder == null || $latestOldOrder->orderno == null){
                $orderNumber = 2000;
            }
            else{
                $orderNumber = (int)$latestOldOrder->orderno;
            }

            $orderNumber += 1;


            // Create Order
            $order = Order::create([
                "user_id" => session()->get('user')->id,
                'orderno' => $orderNumber,
                'amount' => $totalAmount,
                'status' => 0
            ]);

            // Save Order Products & Reduce Stock
            foreach ($cart as $productId => $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                // Reduce stock
                $product = Product::find($productId);
                $product->quantity -= $item['quantity'];
                $product->save();
            }
        
            

        

            // Save Delivery Info
            Delivery::create([
                'order_id' => $order->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'province' => $request->province,
                'city' => $request->city,
                'building' => $request->building,
                'area' => $request->area,
                'address' => $request->address,
                'order_num' => $request->random
                
            ]);

            // Clear Cart
            session()->forget('cart');
            DB::commit();
            return redirect()->route('orders')->with('success', 'Your order has been placed successfully!');

        }

        catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('checkout.get')->with('error', 'Your order has not placed successfully!');
        }
        }

        // Show all orders
        public function allOrders(Request $request)
        {
            if (session()->exists('user') && (session()->get('user')->user_type == 'admin')) 
                
            {
            
                $orders = Order::with('user')->latest()->paginate(10);

                $currentPage = $request->input('page', 1);

                if ($currentPage > $orders->lastPage())
                    {
                    return redirect()->route('orders')->with('error', "Page = {$currentPage} does not exist. The last page number is {$orders->lastPage()}.");
                    }
            } 

                else {
                     $orders = Order::with('user')->where("user_id", session()->get("user")->id)->latest()->paginate(10); 
                     }

                        return view('orders.orderRecords', compact('orders'));
        }


    // Show order delivery address information
    public function delivery($id)
    {
        $deliverie = Delivery::where('order_id', $id)->first();
        return view('orders.delivery',  compact('deliverie'));
    }


    // Update order status
    public function updateStatus(Request $request)
    {
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'status' => 'required|in:0,1,2,3,4,5'
    ]);

    $order = Order::findOrFail($request->order_id);
    $order->status = $request->status;
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Order status updated successfully'
    ]);
    }



        

    public function print_pdf($id)

    {

        $order = Order::find($id);
           
        $pdf = Pdf::loadView('orders.invoice',compact('order'));

        return $pdf->download('invoice.pdf');
               
    }



    
}
