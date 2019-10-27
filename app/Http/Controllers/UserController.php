<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class UserController extends Controller
{
    public static function sendMail($user, $subject, $message, Mailer $mailer)
    {
        $mailer->to($user->email)
            ->send(new SubscriberMails($user, $subject, $message));
    }

    public function index()
    {
        $user = User::orderBy('id', 'DESC')
            ->get();
        return response()->json([
            "success" => true, "data" => $user
        ], 200);
    }

    public function tenants()
    {
        /*$user = Role::users()->where('name','Tenant')->orderBy('id', 'DESC')
            ->get();*/
        //dd(Role::where('name', 'Landlord')->first());
        $user = User::where('role', 'tenant')->get();
        return response()->json([
            "success" => true, "data" => $user
        ], 200);
    }

    public function landlords()
    {
        /*$user = User::orderBy('id', 'DESC')
            ->get();*/
        $user = User::where('role', 'landlord')->get();
        return response()->json([
            "success" => true, "data" => $user
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {

            return response()->json([
                "success" => true, "data" => $user
            ], 200);
        } else {
            return response()->json([
                "success" => false, "data" => "Record not Found"
            ], 200);
        }
    }

    public function visits()
    {
        $user = Auth::user();
        //$visits = user()->visits()->get();
        if ($user->hasRole('Admin')) {
            $visits = \App\Shop::join('visits', 'shops.id', '=', 'visits.shop_id')
                ->orderBy('shops.id', 'DESC')
                ->get();
            return response()->json([
                "success" => true, "data" => $visits
            ], 200);
        }

        if ($user->hasRole('Tenant')) {
            $visits = \App\Shop::join('visits', 'shops.id', '=', 'visits.shop_id')
                ->where('user_id', user()->id)
                ->orderBy('shops.id', 'DESC')
                ->get();
            return response()->json([
                "success" => true, "data" => $visits
            ], 200);
        }
    }

    public function store(Request $request)
    {

        $validator = $this->validator($request->all());
        if ($validator->passes()) {
            $user = new User;


            if (isset($request['avatar']) && !empty($request['avatar'])) {
                $avatar = $request->avatar;
                $filename = $avatar->getClientoriginalName();
                $avatar->move(public_path('uploads/avatars'), $filename);
                $user->avatar = $filename;
            }
            $user->password = $request['password'];
            $user->firstname = $request['firstname'];
            $user->lastname = $request['lastname'];
            $user->phone_number = $request['phone_number'];
            $user->email = $request['email'];

            $user->save();
            if (isset($request['role'])) {
                $user->roles()->attach(Role::where('name', $request['role'])->first());
            }
            return response()->json([
                "success" => true, 'data' => (["success" => true, "message" => "Record Added"])
            ], 200);
        } else {
            return response()->json([
                'data' => ([["success" => false, "message" => "Record not Added. " . $validator->errors()]])
            ], 200);
        }


        //return response()->json($user, 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|max:255',
            'firstname' => 'string|string',
            'lastname' => 'string|string',
            'phone_number' => 'string|string',
            'email' => 'required|string|max:255',

        ]);
    }

    public function update(Request $request)
    {


        $user = User::findOrFail($request['id']);

        $is_user = false;
        if (isset($request['avatar']) && !empty($request['avatar'])) {
            $avatar = $request->avatar;
            $featuerd_new = time() . $avatar->getClientoriginalName();
            $avatar->move(public_path('uploads/avatars'), $featuerd_new);
            $user->avatar = $featuerd_new;
        }

        if (isset($request['password']) && !empty($request['password'])) {
            $user->password = $request['password'];
        }
        if (isset($request['firstname']) && !empty($request['firstname'])) {
            $user->firstname = $request['firstname'];
        }

        if (isset($request['lastname']) && !empty($request['lastname'])) {
            $user->lastname = $request['lastname'];
        }

        if (isset($request['email']) && !empty($request['email'])) {
            $user->email = $request['email'];
        }

        if (isset($request['is_user'])) {
            $is_user = true;
        }
        if ($user->update()) {
            return response()->json([
                'data' => (["success" => true, "message" => "Record Updated", "is_user" => $is_user, "img_post" => $user])
            ], 200);
        } else {
            return response()->json([
                'data' => (["success" => false, "message" => "Record not Updated"])
            ], 200);
        }
        //$user->update($request->all());

        //return response()->json($user, 200);
    }

    public function delete(Request $request)
    {
        if (User::find($request['id'])->delete()) {
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

    public function upload()
    {

        if (isset($_POST) == true) {
            $uploads_dir = $_POST['directory'];
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            //$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
            //$file_ext = strtolower(end((explode('.', $_FILES['image']['name']))));
            //dd($file_name);
            $file_ext = strtolower(substr($file_name, (strrpos($file_name, '.') + 1), strlen($file_name)));
            $extensions = array("jpeg", "jpg", "png");/*, "doc", "docx", "pdf", "txt", "rtf", "svg","csv", "xls", "xlsx"*/
            if (in_array($file_ext, $extensions) === false) {
                //$errors[]="extension not allowed, please choose a JPEG or PNG file.";
                $errors[] = "extension not allowed.";
            }
            if ($file_size > (1048576) * 5) {
                $errors[] = 'File size grater than 5 MB';
            }
            if (empty($errors) == true) {
                $upload_path = public_path('uploads/' . $uploads_dir . "/" . $file_name);
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $msg['success'] = true;
                    $msg['message'] = "File Uploaded Successfully";
                    $user_id = Auth::user()->id;
                    $object = User::where("id", $user_id)->first();
                    $object->avatar = $file_name;
                    $object->update();
                    $msg['filename'] = $file_name;
                }
            } else {
                $myfile = fopen("log.txt", "w") or die("Unable to open file!");
                $msg = "File Not Uploaded";
                $txt = implode("\n", $errors);
                fwrite($myfile, $txt);
                fclose($myfile);
            }
        }
        return Response::json($msg, 200);
        //return response()->json(['success' => 'Images Uploaded Successfully.']);
        //return redirect('/products-uploads')->with('success', 'Member successfully added to database');
    }

    public function postSignIn(Request $request)
    {
        /* if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
          return redirect()->route('main');
          } */
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            //return redirect()->route('main');
            //return redirect()->route('dashboard');
            return Response::json([
                'data' => (["success" => true, "message" => "Access Granted"])
            ], 200);
        }
        //return redirect()->back();
        return Response::json([
            'data' => (["success" => false, "message" => "Invalid Username or Password"])
        ], 200);
    }
}
