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

class LogController extends Controller
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

        ftp_get($conn, $banLocal, $banServer, FTP_BINARY);

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
        $list = ftp_mlsd($conn, '/Logs/');
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
            $localFile = 'assets/Logs/' . $file;
            $serverFile = '/Logs/'. $file;

            ftp_get($conn, $localFile, $serverFile, FTP_BINARY);

            $fp = @fopen($localFile, "r");
            if ($fp) {
                $detect = '';
                $time = '';
                $path = '';
                $hardware = '';
                $hardwarev2 = '';
                $account = '';
                $character = '';
                while (($buffer = fgets($fp, 4096)) !== false) {
                    if (str_starts_with($buffer, 'Local Time:')) $time = substr($buffer,14);
                    else if (str_starts_with($buffer, 'Hack Detect:')) $detect = substr($buffer,16);
                    else if (str_starts_with($buffer, 'Full Path:')) $path = substr($buffer,16);
                    else if (str_starts_with($buffer, 'HardwareID:')) $hardware = chop(substr($buffer,16));
                    else if (str_starts_with($buffer, 'HardwareID v2:')) $hardwarev2 = chop(substr($buffer,16));
                    else if (str_starts_with($buffer, 'Account:')) $account = chop(substr($buffer,16));
                    else if (str_starts_with($buffer, 'Character:')) $character = chop(substr($buffer,16));
                    else {
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
                                'time' => $time,
                                'detect' => $detect,
                                'path' => $path,
                                'hardware' => $hardware,
                                'hardwarev2' => $hardwarev2,
                                'account' => $account,
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

                            $detect = '';
                            $time = '';
                            $path = '';
                            $hardware = '';
                            $hardwarev2 = '';
                            $account = '';
                            $character = '';
                        }
                    }
                }
            }
        }
        ftp_close($conn);
        usort($files, function($a, $b) {
            return $a['modify'] < $b['modify'];
        });
        return view('logs', [
            'files' => $files,
            'contents' => $contents,
            'banlist'=>$banlist,
            'curfile' => $file,
            'request' => $request,
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

    public function banadd (Request $request)
    {
        $hardware = $request->hardware;
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        if (strlen($hardware) <= 0)
            return response()->json('failed');

        $banServer = '/BanHwID/BanHwID.txt';
        $banLocal = tempnam(sys_get_temp_dir(), 'BHW');

        ftp_get($conn, $banLocal, $banServer, FTP_BINARY);
        $content = file_get_contents($banLocal);
        $content = $content.$hardware.PHP_EOL;
        file_put_contents($banLocal, $content);

        $res = ftp_put($conn, $banServer, $banLocal, FTP_BINARY);
        ftp_close($conn);

        if (!$res) {
            return response()->json('failed');
        }
        return response()->json('success');
    }

    public function bandelete (Request $request)
    {
        $hardware = $request->hardware;
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $banServer = '/BanHwID/BanHwID.txt';
        $banLocal = tempnam(sys_get_temp_dir(), 'BHW');

        ftp_get($conn, $banLocal, $banServer, FTP_BINARY);

        $content = file_get_contents($banLocal);
        $content = str_replace($hardware."\n", "",$content);
        $content = str_replace("\n".$hardware, "",$content);

        file_put_contents($banLocal, $content);

        $putret = ftp_put($conn, $banServer, $banLocal, FTP_BINARY);

        ftp_close($conn);

        if (!$putret) {
            return response()->json('failed');
        }
        return response()->json('success');
    }

    public function delete (Request $request)
    {
        $logfile = $request->logfile;

        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $localFile = 'assets/Logs/' . $logfile;
        $serverFile = '/Logs/'.$logfile;

        if (file_exists($localFile))
            unlink(realpath($localFile));

        ftp_delete($conn, $serverFile);
        ftp_close($conn);
        return response()->json('success');
    }
}