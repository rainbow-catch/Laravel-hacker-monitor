<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FTPController extends Controller
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
    public function index()
    {
        return view('ftplogin');
    }

    public function login (Request $request)
    {
        $conn = ftp_connect($request->address);

        if ($conn) {
            if (@ftp_login($conn, $request->username, $request->password)) {

                if ($request->hasSession()) {
                    $request->session()->put('ftpaddress', $request->address);
                    $request->session()->put('ftpusername', $request->username);
                    $request->session()->put('ftppassword', $request->password);
                }

                return redirect('/home')->with('message', 'Success');
            }
        }
        ftp_close($conn);
        return redirect('/ftp')->with('message', 'Failed');
    }

    public  function install (Request $request)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        @ftp_mkdir($conn, 'BanHwID');
        @ftp_mkdir($conn, 'Logs');
        @ftp_mkdir($conn, 'ScreenShots');
        @ftp_mkdir($conn, 'Connect');
        @file_put_contents('temp.txt', '');
        @ftp_nb_put($conn, 'BanHwID/BanHwID.txt', 'temp.txt', FTP_BINARY);
          @ftp_nb_put($conn, 'Connect/Connect.txt', 'temp.txt', FTP_BINARY);
        return redirect('/home');
    }
    public  function reinstall (Request $request)
    {
        return $this->install($request);
    }
    public  function uninstall (Request $request)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        $success = true;
        $success  &= $this->ftp_rdel($conn,'BanHwId');
        $success  &= $this->ftp_rdel($conn,'Logs');
        $success  &= $this->ftp_rdel($conn,'ScreenShots');
        $success  &= $this->ftp_rdel($conn,'Connect');
        if ($success)
            return redirect('/home');
    
    }
}
