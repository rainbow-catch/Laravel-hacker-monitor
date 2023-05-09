<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLicenseSettingRequest;
use App\Http\Requests\UpdateLicenseSettingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $ip = $user->ip;

        return view('admin.licenseSetting', compact(['ip', 'user']));
    }

    public function save(Request $request){
        $setting = LicenseSetting::find(1);

        $setting->name = $request->has('name');
        $setting->memory = $request->has('memory');
        $setting->launcher = $request->has('launcher');
        $setting->crc32 = $request->has('crc32');
        $setting->system = $request->has('system');
        $setting->instance = $request->has('instance');

        $setting->save();
        return redirect()->back();
    }
}
