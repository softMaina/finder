<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::get();
        if ($services) {

            return response()->json([
                "success" => true, "data" => $services
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function show($id)
    {
        $services = Services::find($id);
        if ($services) {

            return response()->json([
                "success" => true, "data" => $services
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
            $services = Services::create($request->all());
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($services, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|email|max:255|unique:users',
            'charges' => 'required|string',
            'club_id' => 'required|integer',
        ]);
    }

    public function update(Request $request, $id)
    {

        $services = Services::findOrFail($id);
        if ($services->update($request->all())) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Updated"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Updated"]])
            ], 200);
        }
        //$services->update($request->all());

        //return response()->json($services, 200);
    }

    public function delete($id)
    {
        if (Services::find($id)->delete()) {
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
