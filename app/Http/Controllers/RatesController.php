<?php

namespace App\Http\Controllers;

use App\Rates;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function index()
    {
        $rates = Rates::get();
        if ($rates) {

            return response()->json([
                "success" => true, "data" => $rates
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function show($id)
    {
        $rates = Rates::find($id);
        if ($rates) {

            return response()->json([
                "success" => true, "data" => $rates
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $guard = $request->has('api_token') ? 'api' : 'session';
        //$authUser = Auth::guard($guard)->user();
        //$this->validator($request->all())->validate();
        if ($this->validator($request->all())->passes()) {
            $rates = Rates::create($request->all());
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($rates, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|int',
            'club_id' => 'required|int',
            'comment' => 'required|string|max:255',
            'description' => 'required|string|max:255|unique:user',
            'rated' => 'required|integer|max:1',

        ]);
    }

    public function update(Request $request, $id)
    {

        $rates = Rates::findOrFail($id);
        if ($rates->update($request->all())) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Updated"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Updated"]])
            ], 200);
        }
        //$rates->update($request->all());

        //return response()->json($rates, 200);
    }

    public function delete($id)
    {
        if (Rates::find($id)->delete()) {
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
}
