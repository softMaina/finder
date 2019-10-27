<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::get();
        if ($role) {

            return response()->json([
                "success" => true, "data" => $role
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        if ($role) {

            return response()->json([
                "success" => true, "data" => $role
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
            $role = Role::create($request->all());
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($role, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',

        ]);
    }

    public function update(Request $request, $id)
    {

        $role = Role::findOrFail($id);
        if ($role->update($request->all())) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Updated"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Updated"]])
            ], 200);
        }
        //$role->update($request->all());

        //return response()->json($role, 200);
    }

    public function delete($id)
    {
        if (Role::find($id)->delete()) {
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
