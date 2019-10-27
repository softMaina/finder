<?php

namespace App\Http\Controllers;

use App\Shop;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

class ShopController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $shop = Shop::orderBy('id', 'DESC')->get();
            return response()->json([
                "success" => true, "data" => $shop
            ], 200);
        } else {
            $shop = user()->shops()->get();
            return response()->json([
                "success" => true, "data" => $shop
            ], 200);
        }
    }

    public function show($id)
    {
        $shop = Shop::find($id);
        if ($shop) {

            return response()->json([
                "success" => true, "data" => $shop
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function store(Request $request)
    {
        if ($this->validator($request->all())->passes()) {
            $shop = new Shop;

            $shop->location = $request['location'];
            //$shop->status = $request['status'];
            $shop->name = $request['name'];
            $shop->size = $request['size'];
            $shop->price = $request['price'];
            $shop->description = $request['description'];
            if (isset($request['image']) && !empty($request['image'])) {
                $image = $request->image;
                $filename = $image->getClientoriginalName();
                $image->move(public_path('uploads/shops/'), $filename);
                $shop->image = $filename;
            }
            $result = $shop->save();
            //
            user()->shops()->save($shop);
            return response()->json([
                "success" => true, 'data' => (["success" => true, "message" => "Record Added"])
            ], 200);

            return response()->json([
                "success" => true, 'data' => ([["message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($shop, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'string|string',
            'description' => 'required|string|max:255',
            'location' => 'required|string',
        ]);
    }

    public function update(Request $request)
    {


        $shop = Shop::findOrFail($request['id']);

        if (isset($request['image']) && !empty($request['image'])) {
            $image = $request->image;
            $filename = $image->getClientoriginalName();
            $image->move(public_path('uploads/shops'), $filename);
            $shop->image = $filename;
        }

        if (isset($request['status']) && !empty($request['status'])) {
            $shop->status = $request['status'];
        }
        if (isset($request['name']) && !empty($request['name'])) {
            $shop->name = $request['name'];
        }
        if (isset($request['description']) && !empty($request['description'])) {
            $shop->description = $request['description'];
        }

        if (isset($request['location']) && !empty($request['location'])) {
            $shop->location = $request['location'];
        }

        if (isset($request['size']) && !empty($request['size'])) {
            $shop->size = $request['size'];
        }

        if (isset($request['price']) && !empty($request['price'])) {
            $shop->price = $request['price'];
        }
        if ($shop->update()) {
            return response()->json([
                'data' => (["success" => true, "message" => "Record Updated", "post" => $shop])
            ], 200);
        } else {
            return response()->json([
                'data' => (["success" => false, "message" => "Record not Updated"])
            ], 200);
        }
        //$shop->update($request->all());

        //return response()->json($shop, 200);
    }


    public function delete(Request $request)
    {
        if (Shop::find($request['id'])->delete()) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Deleted"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Deleted"]])
            ], 200);
        }

        //return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $name = $request["name"];
        $location = $request["location"];
        $size = $request["size"];
        $price = $request["price"];
        $all = Shop::get();
        $shops = new Collection();
        //$search->clear();
        foreach ($all as $duka) {
            if (Str::contains(Str::lower($duka->name), Str::lower($name)) || Str::contains(Str::lower($duka->location), Str::lower($location)) || Str::contains(Str::lower($duka->size), Str::lower($size)) || Str::contains(Str::lower($duka->location), Str::lower($price))) {
                $shops->add($duka);
            }
        }
        return View::make('pages.search.shops')->with('shops', $shops);
    }

    public function shopvisit(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'data' => (["auth" => false, "message" => "Please login to continue"])
            ], 200);
        } else {
            return response()->json([
                'data' => (["auth" => true, "message" => "Please Book a visit"])
            ], 200);
        }

        $id = $request["id"];
        $shop = \App\Shop::find($id);
        $location = $request["location"];

        return 'Paid';
    }

    public function requestvisit(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'data' => (["success" => false, "message" => "Please login to continue"])
            ], 200);
        } else {
            $id = $request["id"];
            $time = $request["time"];
            $message = $request["message"];
            $visit = \App\Visit::create([
                'user_id' => user()->id,
                'shop_id' => $id,
                'visiting_time' => $time,
                'message' => $message,

            ]);
            return response()->json([
                'data' => (["success" => true, "post" => $visit])
            ], 200);
        }
    }

    public function shoppay(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'data' => (["success" => false, "message" => "Please login to continue"])
            ], 200);
        }

        $id = $request["id"];
        $shop = \App\Shop::find($id);
        $user_id = user()->id;
        $shop_id = $shop->id;
        $amount = $shop->price;
        $transaction_id = 'TRXN - ' . $shop_id . '-' . time();

        $payment_status = 'PAID';

        $paymant_method = $shop_id % 2 ? 'Cash' : 'Card';


        $payment = \App\Payment::create([
            'user_id' => $user_id,
            'shop_id' => $shop_id,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'payment_status' => $payment_status,
            'paymant_method' => $paymant_method,
        ]);
        return response()->json([
            'data' => (["success" => true, "message" => "Payment Successful", "post" => $payment])
        ], 200);
    }
}
