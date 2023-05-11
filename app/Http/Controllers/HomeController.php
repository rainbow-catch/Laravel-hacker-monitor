<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null){
            return redirect('/ftp');
        }

        $banExist = $this->is_folder($conn, 'BanHwID');
        $logsExist = $this->is_folder($conn, 'Logs');
        $screensExist = $this->is_folder($conn, 'ScreenShots');
        $connectExist = $this->is_folder($conn, 'Connect');
        $banFileExist = false;
        if($banExist) {
            $banFileExist = (@ftp_nb_get($conn, 'Temp.txt', '/BanHwID/BanHwID.txt',FTP_BINARY) != FTP_FAILED);
        }
        $complete = $banExist && $logsExist && $screensExist && $banFileExist && $connectExist;
        $incomplete = !$complete && ($banExist || $logsExist || $screensExist || $banFileExist || $connectExist);
        return view('home', [
            'complete' => $complete,
            'incomplete' => $incomplete
        ]);
    }
}
