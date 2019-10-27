<?php

namespace App\Http\Controllers;

use App\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    public function index()
    {
        $club = Club::get();
        if ($club) {

            return response()->json([
                "success" => true, "data" => $club
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function show($id)
    {
        $club = Club::find($id);
        if ($club) {

            return response()->json([
                "success" => true, "data" => $club
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
            $club = Club::create($request->all());
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($club, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ]);
    }

    public function update(Request $request, $id)
    {

        $club = Club::findOrFail($id);
        if ($club->update($request->all())) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Updated"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Updated"]])
            ], 200);
        }
        //$club->update($request->all());

        //return response()->json($club, 200);
    }

    public function delete($id)
    {
        if (Club::find($id)->delete()) {
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
