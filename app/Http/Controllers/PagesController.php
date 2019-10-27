<?php

namespace App\Http\Controllers;

use App\Shop;
use App\User;
use App\ShopSize;
use App\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('dashboard');
    }
    //
    public function index()
    {
        $shops = $this->getShops();

        $propertyTypes = PropertyType::all();
        $shopSizes = ShopSize::all();

        return view('pages.index', [
            'shops' => $shops,
            'propertyTypes' => $propertyTypes,
            'shopSizes' => $shopSizes
        ]);
    }

    public function shopdetails(Shop $shop)
    {
        $shop = $shop->load('shop_location', 'shop_status', 'shop_images', 'shop_size');
        $featured = \App\Shop::where('id', '!=', $shop->id)
            ->with('shop_location', 'shop_status', 'shop_images', 'shop_size')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        return view('pages.shop-details', [
            'shop' => $shop,
            'featured' => $featured
        ]);
    }

    public function gallery()
    {
        $shops = \App\Shop::get();
        return view('pages.gallery', compact('shops'));
    }

    /*============= Backend ===============*/

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            abort(404);
        }

        if ($user->hasRole('Admin')) {
            return view('pages.backend.users');
        } else if ($user->hasRole('Landlord')) {
            return view('pages.backend.shops');
        } else if ($user->hasRole('Tenant')) {
            return view('pages.backend.shops');
            /*if(user()->hasShop()){
                return view('pages.backend.shops');
            }else{
                return redirect()->route('index');
            }*/
        }

        /*if(\App\Visit::hasUserVisitedShop($this->user()->id)){

        }else{

        }*/
    }

    public function shops()
    {
        $shops = \App\Shop::get();
        return view('pages.backend.shops', compact('shops'));
    }


    public function users()
    {
        return view('pages.backend.users');
    }

    public function tenants()
    {
        $tenants = User::where('role', '=', 'tenant')->get();
        return view('pages.backend.tenants', compact('tenants'));
    }

    public function landlords()
    {
        return view('pages.backend.landlords');
    }

    public function userId($id)
    {
        $user = \App\User::find($id);
        //dd($user->roles()->first());
        return view('pages.backend.user-details', compact('user'));
    }

    public function visits()
    {
        return view('pages.backend.visits');
    }

    public function profile()
    {
        return view('pages.backend.profile');
    }

    public function search(Request $request)
    {
        $shops = Shop::with(
            'shop_location',
            'shop_size',
            'shop_type',
            'shop_images',
            'shop_status'
        )
            ->when(isset($request->location), function ($query) use ($request) {
                return $query->whereHas('shop_location', function ($q) use ($request) {
                    $q->where('location', 'LIKE', '%' . $request->location . '%');
                });
            })
            ->when(isset($request->size), function ($query) use ($request) {
                return $query->where('shop_size_id', $request->size);
            })
            ->when(isset($request->price), function ($query) use ($request) {
                return $query->where('price', 'LIKE', '%' . $request->price . '%');
            })
            ->when(isset($request->type), function ($query) use ($request) {
                return $query->where('shop_type_id', $request->type);
            })
            ->latest()
            ->paginage(9);

        return $shops;
    }

    public function favoriteShop(Request $request, Shop $shop)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $user->favorite_shops()->attach($shop->id);

        return response()->json([
            'message' => 'Shop added to your favorite list.',
            'shops' => $this->getShops(),
        ], 200);
    }

    public function getShops()
    {
        return Shop::with(
            'shop_status',
            'shop_images',
            'shop_size',
            'shop_location',
        )
            ->latest()
            ->paginate(9);
    }
}
