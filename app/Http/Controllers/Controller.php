<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use phpDocumentor\Reflection\Types\Null_;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $ftpConn = null;

    public function is_folder ($handle, $path) {
        $list = @ftp_nlist($handle, $path);
        return is_array($list);
    }
    public function ftp_rdel ($handle, $path) {
        $success = true;
        if (@ftp_delete ($handle, $path) === false) {
            if ($children = @ftp_nlist ($handle, $path)) {
                foreach ($children as $p)
                    $success &= $this->ftp_rdel ($handle,  $p);
            }

            $success &= @ftp_rmdir ($handle, $path);
        }
        return $success;
    }

    public function checkFtp (Request $request) {
        if ($request->session()->has('ftpaddress')) {
            $ftpaddr = $request->session()->get('ftpaddress');
            $username = $request->session()->get('ftpusername');
            $password = $request->session()->get('ftppassword');
        } else {
            return false;
        }

        $conn = ftp_connect($ftpaddr);
        if ($conn) {
            if (!@ftp_login($conn, $username, $password)) {
                return false;
            }
        } else {
            return false;
        }
        $this->ftpConn = $conn;
        return true;
    }
}
