<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function cart()
    {
        return view('cart');
    }

    public function addToCart($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {

            abort(404);

        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if (!$cart) {

            $cart = [
                $id => [
                    "name" => $shop->name,
                    "quantity" => 1,
                    "price" => $shop->price,
                    "photo" => $shop->photo
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Shop added to cart successfully!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Shop added to cart successfully!');

        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $shop->name,
            "quantity" => 1,
            "price" => $shop->price,
            "photo" => $shop->photo
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Shop added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {

            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Shop removed successfully');
        }
    }
}
