<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use Helper;
use Illuminate\Support\Str;
use App\User;
use Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $shipping = Shipping::all();
        return view('frontend.pages.checkout')->with('shipping', $shipping);
    }

    public function checkoutStore(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required',
            'shipping' => 'required|exists:shippings,id'
        ]);

        if(empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())){
            request()->session()->flash('error', 'Cart is Empty!');
            return back();
        }

        $shipping = Shipping::find($request->shipping);
        if(!$shipping) {
            request()->session()->flash('error', 'Invalid shipping method');
            return back();
        }

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = auth()->user()->id;
        $order_data['shipping_id'] = $shipping->id;
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        $order_data['status'] = 'new';
        $order_data['total_amount'] = Helper::totalCartPrice() + (float)$shipping->price;
        
        $order->fill($order_data);
        $status = $order->save();
        
        if($status){
            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
            request()->session()->flash('success', 'Your order successfully placed');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error', 'Please try again!!');
            return back();
        }
    }
}
