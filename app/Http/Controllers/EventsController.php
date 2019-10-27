<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $events = Events::get();
        if ($events) {

            return response()->json([
                "success" => true, "data" => $events
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function show($id)
    {
        $events = Events::find($id);
        if ($events) {

            return response()->json([
                "success" => true, "data" => $events
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
            $events = Events::create($request->all());
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Added"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added"]])
            ], 200);
        }


        //return response()->json($events, 201);
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

        $events = Events::findOrFail($id);
        if ($events->update($request->all())) {
            return response()->json([
                'data' => ([["success" => true, "message" => "Record Updated"]])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Updated"]])
            ], 200);
        }
        //$events->update($request->all());

        //return response()->json($events, 200);
    }

    public function delete($id)
    {
        if (Events::find($id)->delete()) {
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
