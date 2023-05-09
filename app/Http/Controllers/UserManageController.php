<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->approve != '2')
            return redirect('/home');
        $data = User::orderBy('id', 'DESC')->get();
        foreach ($data as $item) {
            if ($item->enddate != null && $item->enddate < Date::now() && $item->approve)
            {
                $approveUpdate = [
                    'approve' => "0"
                ];
                User::where('id', $item->id)->update($approveUpdate);
            }
        }
        $data = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', ['users' => $data]);
    }

    public function user_save(Request $request) {
        if (Auth::user()->approve != '2')
            return response()->json('failed');

        $data = $request->parms;
        $userId = $data[0];
        $user_check = User::where('id', $userId)->get();
        $new_user = false;
        if(!$data[0])
        {
            User::create([
                'name' => $data[1],
                'email' => $data[2],
                'password' => Hash::make($data[3]),
                'password1' => $data[3],
                'approve' => '0',
                'ip' => $data[4],
                'enddate' => $data[5],
                'version' => $data[6]
            ]);
        }
        else
        {
            $userUpdate = [
                'name' => $data[1],
                'email' => $data[2],
                'password' => Hash::make($data[3]),
                'password1' => $data[3],
                'ip' => $data[4],
                'enddate' => $data[5],
                'version    ' => $data[6],
            ];
            User::where('id', $userId)->update($userUpdate);
            $new_user = true;
        }
        $user = User::get()->last();
        $result['user_id'] = $user->id;
        $result['new_user'] = $new_user;

        return response()->json($result);
    }

    public function changePassword(Request $request) {
        try {
            $user = User::find(Auth::user()->id);
            $user->password1 = $request->input('password');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json("success", 200);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
    public function changeAvatar(Request $request) {
        try {
            $user = User::find(Auth::user()->id);
            $user->avatar = $request->input('avatar');
            $user->save();
            return response()->json("success", 200);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
    public function user_delete(Request $request) {
        if (Auth::user()->approve != '2')
            return response()->json('failed');

        User::where('id', $request->id)->delete();
    }

    public function approve(Request $request) {
        if (Auth::user()->approve != '2')
            return response()->json('failed');

        $user_id = $request->id;
        $approve_status = User::where('id', $user_id)->select('approve')->get();
        $status = $approve_status[0]->approve;
        if( $status == "0")
            $approveUpdate = [
                'approve' => "1"
            ];
        else
            $approveUpdate = [
                'approve' => "0"
            ];
        User::where('id', $user_id)->update($approveUpdate);
        return response()->json($approveUpdate);
    }

    public function getUsers() {
    }

}
