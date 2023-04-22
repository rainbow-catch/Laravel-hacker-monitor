<?php
/**
 * Created by PhpStorm.
 * User: R
 * Date: 9/19/2022
 * Time: 1:14 PM
 */

namespace App\Http\Controllers;

use DateTime;
use http\Env\Response;
use Illuminate\Http\Request;
use function Symfony\Component\Console\Input\hasArgument;
use function Symfony\Component\Finder\searchInDirectory;

class ConnectLogController extends Controller
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

    public function logview (Request $request, $file)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $banServer = '/BanHwID/BanHwID.txt';
        $banLocal = tempnam(sys_get_temp_dir(), 'BHW');

        $ret = @ftp_nb_get($conn, $banLocal, $banServer, FTP_BINARY);
        while ($ret == FTP_MOREDATA) {
            $ret = ftp_nb_continue($conn);
        }

        $banlist = [];
        $banfp = @fopen($banLocal, "r");
        if ($banfp) {
            while (($buffer = fgets($banfp, 4096)) !== false) {
                if (strlen($buffer) > 0)
                    array_push($banlist, chop($buffer));
            }
        }

        // filter
        $datestart = DateTime::createFromFormat('m/d/Y H:i', $request['date-start'].' '.$request['time-start']);
        $dateend = DateTime::createFromFormat('m/d/Y H:i', $request['date-end'].' '.$request['time-end']);
        $files = [];
        $list = ftp_mlsd($conn, '/Connect/');
        if (is_array($list)) {
            foreach ($list as $item) {
                if ($item['type'] == 'file') {
                    $filetime = DateTime::createFromFormat('YmdHis', $item['modify']);

                    if ($datestart != false) {
                        if ($filetime < $datestart)
                            continue;
                    }
                    if ($dateend != false) {
                        if ($filetime > $dateend)
                            continue;
                    }
                    array_push($files, $item);
                }
            }
        }
        $contents = [];

        // filter
        $search = strtolower($request['search']);
        if ($file != '') {
            $localFile = 'assets/Connect/' . $file;
            $serverFile = '/Connect/'. $file;

            $ret = @ftp_nb_get($conn, $localFile, $serverFile, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn);
            }

            $fp = @fopen($localFile, "r");
            if ($fp) {
                $ip = '';
                $Account = '';
                $character = '';
                $hardware = '';
                $hardwarev2 = '';

                while (($buffer = fgets($fp, 4096)) !== false) {
                    $pieces = explode("|", $buffer);
                    foreach ($pieces as $piece) {
                        $trimed = trim($piece);
                        if (str_starts_with($trimed, 'IP:')) {
                            $ip = trim(substr($trimed,3));
                        }
                        if (str_starts_with($trimed, 'account:')) {
                            $Account = trim(substr($trimed,8));
                        }
                        if (str_starts_with($trimed, 'Character:')) {
                            $character = trim(substr($trimed,10));
                        }
                        if (str_starts_with($trimed, 'HardwareID:')) {
                            $hardware = trim(substr($trimed,11));
                        }
                        if (str_starts_with($trimed, 'HardwareID v2:')) {
                            $hardwarev2 = trim(substr($trimed,14));
                        }
                    }
                    $isbanned = false;
                    foreach ($banlist as $ban) {
                        if (strcmp($ban, $hardware) == 0) {
                            $isbanned = true;
                            break;
                        }
                    }
                    $isbanned2 = false;
                    foreach ($banlist as $ban) {
                        if (strcmp($ban, $hardwarev2) == 0) {
                            $isbanned2 = true;
                            break;
                        }
                    }
                    if (strlen($hardware) > 0) {
                        $isMatch = false;
                        $ban = [
                            'ip' => $ip,
                            'hardware' => $hardware,
                            'hardwarev2' => $hardwarev2,
                            'account' => $Account,
                            'character' => $character,
                            'isbanned' => $isbanned,
                            'isbanned2' => $isbanned2
                        ];
                        foreach ($ban as $bandetail) {
                            if (str_contains(strtolower($bandetail), $search))
                            $isMatch = true;
                        }
                        if ($isMatch)
                            array_push($contents, $ban);

                        $ip = '';
                        $hardware = '';
                        $hardwarev2 = '';
                        $Account = '';
                        $character = '';
                    }
                }
            }
        }
        ftp_close($conn);
        return view('cnlogs', [
            'files' => $files,
            'contents' => $contents,
            'banlist'=>$banlist,
            'curfile' => $file,
            'request' => $request
        ]);
    }

    public function logfiles(Request $request)
    {
        return $this->logview($request, '');
    }
    public function logcontent(Request $request, $file)
    {
        return $this->logview($request, $file);
    }

    public function delete (Request $request)
    {
        $logfile = $request->logfile;

        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $localFile = 'assets/Connect/' . $logfile;
        $serverFile = '/Connect/'.$logfile;

        @file_put_contents($localFile, '');
        ftp_delete($conn, $serverFile, $localFile, FTP_BINARY);

        unlink($localFile);
        ftp_close($conn);

        return response()->json('success');
    }
}