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
        $guests = User::where('approve', 1)->where('parent_id', $id)->get();
        return view('admin.licenseSetting', compact(['guests', 'user']));
    }
}
