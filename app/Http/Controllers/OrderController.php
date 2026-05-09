<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderEmail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the user ID
        $user_id = Auth::user()->id;

        // Fetch the orders for the user
        $user_orders = Order::where('user_id', $user_id)->get();

        // If the user doesn't have any orders
        if ($user_orders->isEmpty()) {
            return response()->json([
                'message' => 'You don\'t have any orders yet',
            ], 400);
        }

        // Initialize a collection to hold the order data
        $ordersdata = collect();

        // Loop through each order
        foreach ($user_orders as $order) {
            // Fetch the products in this order
            $orderproducts = OrderProduct::where('order_id', $order->id)->get();

            // Initialize an array to hold the product details for the current order
            $order_products_details = [];

            // Loop through each product in the order
            foreach ($orderproducts as $orderproduct) {
                // Get the product data
                $product = Product::find($orderproduct->product_id);  // Make sure to reference the correct product ID

                // If product exists, add its data and quantity to the order_products_details array
                if ($product) {
                    $order_products_details[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $orderproduct->quantity,
                        'price' => $product->price, // You can add more fields as required
                        'product_data' => $product, // If you want to return more product details
                    ];
                }
            }
            $formatted_order_date = $order->created_at->format('Y-m-d H:i');  // Format as 'YYYY-MM-DD HH:MM'


            // Add this order's details to the ordersdata collection
            $ordersdata->push([
                'order_id' => $order->id,
                'order_date' => $formatted_order_date,  // Example: include the order date
                'status' => $order->status,  // Add the status of the order
                'total_amount' => $order->total,  // Example: include the total amount if applicable
                'products' => $order_products_details,  // Add the product details
            ]);
        }

        // Return the orders with their product data, quantities, and order status
        return response()->json([
            'orders' => $ordersdata
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'payment' => 'required|in:cash,bank,syriatelcash,mtncash',
            'place' => 'required|string',
            'street' => 'nullable|string',
            'buildingfloor' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);
        $carts = Cart::where('user_id', $user_id)->where('status', 'active')->get();
        if ($carts->isEmpty()) {
            return response()->json([
                'message' => 'You don\'t have any products in your cart to order',
            ], 400);
        }
        $subtotal=0;
        foreach ($carts as $item) {
            $subtotal += (float)$item->quantity * (float)$item->product->price;


            $pp = Product::find($item->product_id);
            if ($pp->quantity < $item->quantity) {
                return response()->json([
                    'message' => 'You need to change quantity as exist',
                ], 400);
            }
            $pp->quantity = $pp->quantity - $item->quantity;
            $pp->save();
        }

        $neworder = new Order();
        // $neworder->status = "storeconfirm";
        $neworder->status = "transconfirm";
        $neworder->payment = $request->payment;
        $neworder->total = $subtotal;
        $neworder->place = $request->place;
        $neworder->street = $request->street;
        $neworder->buildingfloor = $request->buildingfloor;
        $neworder->phone = $request->phone;
        $neworder->mainphone = Auth::user()->phone;
        $neworder->description = $request->description;
        $neworder->user_id = $user_id;
        $neworder->save();

        foreach ($carts as $item) {
            $neworderproduct = new OrderProduct();
            $neworderproduct->quantity = $item->quantity;
            $neworderproduct->order_id = $neworder->id;
            $neworderproduct->product_id = $item->product_id;
            $neworderproduct->save();

            $item->status = 'completed';
            $item->save();
        }
        SendOrderEmail::dispatch($neworder);

            return response()->json([
                'message' => 'order placed successfully',
            ], 200);
    }

    public function StoreConfirm(Request $request) {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',  // product_id must be a valid integer and must exist in products table
        ]);
        $order_id = $request->order_id;

        $order = Order::find($order_id);
        if (!$order) {
            return response()->json([
                'message' => 'invalid order_id',
            ], 400);
        }
        if ($order->status != 'storeconfirm') {
            return response()->json([
                'message' => 'invalid use api',
            ], 400);
        }
        $order->status = 'transconfirm';
        $order->save();
        return response()->json([
            'message' => 'status change to transconfirm',
        ], 200);
    }
    public function TransConfirm(Request $request) {
        $deliveryid=Auth::user()->id;
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
        ]);
        $order_id=$request->order_id;
        $order=Order::find($order_id);
        $order->status = 'userconfirm';
        $order->delivery_id=$deliveryid;
        $order->save();
        return response()->json([
            'message' => 'status change to userconfirm',
        ], 200);
    }
    public function UserConfirm(Request $request) {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',  // product_id must be a valid integer and must exist in products table
        ]);
        $order_id = $request->order_id;

        $order = Order::find($order_id);
        if (!$order) {
            return response()->json([
                'message' => 'invalid order_id',
            ], 400);
        }
        if ($order->status != 'userconfirm') {
            return response()->json([
                'message' => 'invalid use api',
            ], 400);
        }
        $order->status = 'shipped';
        $order->save();
        return response()->json([
            'message' => 'status change to shipped',
        ], 200);
    }

    public function AllOrders()
    {
        // Fetch all orders ordered by status: first orders that are not 'shipped', then 'shipped'
        $orders = Order::orderByRaw("CASE WHEN status = 'shipped' THEN 1 ELSE 0 END, created_at DESC")
                       ->get();

        // If you want to return the orders with product details
        $ordersdata = collect();

        foreach ($orders as $order) {
            // Fetch the products in this order
            $orderproducts = OrderProduct::where('order_id', $order->id)->get();

            // Initialize an array to hold the product details for the current order
            $order_products_details = [];

            // Loop through each product in the order
            foreach ($orderproducts as $orderproduct) {
                // Get the product data
                $product = Product::find($orderproduct->product_id);

                // If product exists, add its data and quantity to the order_products_details array
                if ($product) {
                    $order_products_details[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $orderproduct->quantity,
                        'price' => $product->price,
                        'product_data' => $product,
                    ];
                }
            }

            // Format the order date
            $formatted_order_date = $order->created_at->format('Y-m-d H:i');

            // Add this order's details to the ordersdata collection
            $ordersdata->push([
                'order_id' => $order->id,
                'order_date' => $formatted_order_date,
                'total_amount' => $order->total,
                'status' => $order->status,
                'products' => $order_products_details,
                'delivery_id'=>$order->delivery_id,
            ]);
        }

        // Return the orders with their product data, quantities, and order status
        return response()->json([
            'orders' => $ordersdata
        ], 200);
    }

    public function transConfirmOrders()
    {
        $orders=Order::where('status','transconfirm')
        ->get();
        $ordersdata = collect();
        foreach ($orders as $order) {
            // Fetch the products in this order
            $orderproducts = OrderProduct::where('order_id', $order->id)->get();

            // Initialize an array to hold the product details for the current order
            $order_products_details = [];

            // Loop through each product in the order
            foreach ($orderproducts as $orderproduct) {
                // Get the product data
                $product = Product::find($orderproduct->product_id);

                // If product exists, add its data and quantity to the order_products_details array
                if ($product) {
                    $order_products_details[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $orderproduct->quantity,
                        'price' => $product->price,
                        'product_data' => $product,
                    ];
                }
            }

            // Format the order date
            $formatted_order_date = $order->created_at->format('Y-m-d H:i');

            // Add this order's details to the ordersdata collection
            $ordersdata->push([
                'order_id' => $order->id,
                'order_date' => $formatted_order_date,
                'total_amount' => $order->total,
                'status' => $order->status,
                'products' => $order_products_details,
            ]);
        }

        // Return the orders with their product data, quantities, and order status
        return response()->json([
            'orders' => $ordersdata
        ], 200);

    }


    public function deliveryOrders(){
        $deliveryid=Auth::user()->id;
        $orders=Order::where('delivery_id',$deliveryid)
        ->get();
        $orders=$orders->where('status','userconfirm');
        $ordersdata = collect();
        foreach ($orders as $order) {
            // Fetch the products in this order
            $orderproducts = OrderProduct::where('order_id', $order->id)->get();

            // Initialize an array to hold the product details for the current order
            $order_products_details = [];

            // Loop through each product in the order
            foreach ($orderproducts as $orderproduct) {
                // Get the product data
                $product = Product::find($orderproduct->product_id);

                // If product exists, add its data and quantity to the order_products_details array
                if ($product) {
                    $order_products_details[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $orderproduct->quantity,
                        'price' => $product->price,
                        'product_data' => $product,
                    ];
                }
            }

            // Format the order date
            $formatted_order_date = $order->created_at->format('Y-m-d H:i');

            // Add this order's details to the ordersdata collection
            $ordersdata->push([
                'order_id' => $order->id,
                'order_date' => $formatted_order_date,
                'total_amount' => $order->total,
                'status' => $order->status,
                'products' => $order_products_details,
            ]);
        }

        // Return the orders with their product data, quantities, and order status
        return response()->json([
            'orders' => $ordersdata
        ], 200);
    }


    public function CancelOrder(Request $request) {
        $user_id = Auth::user()->id;
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',  // product_id must be a valid integer and must exist in products table
        ]);
        $order_id = $request->order_id;


        $order = Order::find($order_id);
        if (!$order) {
            return response()->json([
                'message' => 'invalid order_id',
            ], 400);
        }
        if ($order->user_id == $user_id || Auth::user()->role == 'admin') {
            if ($order->status != 'storeconfirm') {
                return response()->json([
                    'message' => 'you cant cancel order now',
                ], 400);
            }

            $prods = OrderProduct::where('order_id', $order_id)->get();
            foreach ($prods as $value) {
                $value->delete();
            }
            $order->delete();

                return response()->json([
                    'message' => 'order deleted successfully',
                ], 200);
        }
        else {
            return response()->json([
                'message' => 'you not have this order',
            ], 400);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
