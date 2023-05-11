<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function checkFtpAndSaveInSession (Request $request, $address, $username, $password)
    {
        $conn = ftp_connect($address);

        if ($conn) {
            if (@ftp_login($conn, $username, $password)) {
                if ($request->hasSession()) {
                    $request->session()->put('ftpaddress', $address);
                    $request->session()->put('ftpusername', $username);
                    $request->session()->put('ftppassword', $password);
                }
                ftp_close($conn);
                return true;
            }
        }
        return false;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->approve == 1){
            $ftp_account = json_decode($user->parent()['last_login'])->ftp;
            $request->input = [
               'address' =>  $ftp_account->address,
               'username' =>  $ftp_account->username,
               'password' =>  $ftp_account->password,
            ];

            $success = $this->checkFtpAndSaveInSession($request, $ftp_account->address, $ftp_account->username, $ftp_account->password);
            if ($success) {
                return redirect("/home");
            }
        }
        return view('ftplogin');
    }

    public function login (Request $request)
    {
        $success = $this->checkFtpAndSaveInSession($request, $request->address, $request->username, $request->password);

        if ($success) {
            $user = Auth::user();
            $lastlogin = json_decode($user->last_login);
            $lastlogin->ftp = [
                'address' => $request->address,
                'username' => $request->username,
                'password' => $request->password
            ];
            $user->last_login = json_encode($lastlogin);
            $user->save();
            return redirect('/home')->with('message', 'Success');
        }
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
