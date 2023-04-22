<?php

namespace App\Http\Controllers;

use App\Models\LicenseSetting;
use App\Http\Requests\StoreLicenseSettingRequest;
use App\Http\Requests\UpdateLicenseSettingRequest;
use Illuminate\Http\Request;

class LicenseSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = LicenseSetting::find(1);
        return view('admin.licenseSetting', ['setting' => $setting->toArray()]);
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
