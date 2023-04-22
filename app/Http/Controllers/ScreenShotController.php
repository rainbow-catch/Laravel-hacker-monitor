<?php
/**
 * Created by PhpStorm.
 * User: R
 * Date: 9/19/2022
 * Time: 1:14 PM
 */

namespace App\Http\Controllers;

use DateTime;
use GuzzleHttp\Promise\AggregateException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;
use function Symfony\Component\HttpFoundation\add;
use function Termwind\Components\toString;

class ScreenShotController extends Controller
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

    public function folders (Request $request)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        $folders = [];
        $list = ftp_mlsd($conn, '/ScreenShots/');
        if (is_array($list)) {
            foreach ($list as $item) {
                if ($item['type'] == 'dir') {
                    array_push($folders, $item);
                }
            }
        }
        usort($folders, function ($a, $b) {
            $date1 = DateTime::createFromFormat('Y-m-d', $a['name']);
            if ($date1 == false)
                $date1 = DateTime::createFromFormat('d-m-Y', $a['name']);
            if ($date1 == false)
                $date1 = $a['name'];
            else
                $date1 = $date1->format('Y-m-d');

            $date2 = DateTime::createFromFormat('Y-m-d', $b['name']);
            if ($date2 == false)
                $date2 = DateTime::createFromFormat('d-m-Y', $b['name']);
            if ($date2 == false)
                $date2 = $b['name'];
            else
                $date2 = $date2->format('Y-m-d');
            return strcmp($date1, $date2);
        });
        return view('screenfolders', ['folders' => $folders]);
    }

    public function images (Request $request, $folder)
    {
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        $images = [];
        $list = ftp_mlsd($conn, '/ScreenShots/'.$folder);
        foreach ($list as $item) {
            if ($item['type'] != 'dir' && $item['type'] != 'pdir' && $item['type'] != 'cdir') {
                array_push($images, $item);
            }
        }
        return view('screenshots', [
            'folder' => $folder,
            'images' => $images
        ]);
    }

    public function image (Request $request)
    {
        $folder = $request->folder;
        $image = $request->image;
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $localFile = 'assets/images/screenshots/'.$folder.$image;
        $serverFile = '/ScreenShots/' . $folder . '/' . $image;
        if (file_exists($localFile))
            return response()->json($localFile);

        $ret = @ftp_nb_get($conn, $localFile, $serverFile, FTP_BINARY);
        while ($ret == FTP_MOREDATA) {
            $ret = ftp_nb_continue($conn);
        }
        return response()->json($localFile);
    }

    public function delfolder (Request $request)
    {
        $folder = $request->folder;
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $serverFile = '/ScreenShots/' . $folder;

        if ($this->ftp_rdel($conn, $serverFile))
            return response()->json('success');
        return response()->json('failed');
    }

    public function delete (Request $request)
    {
        $folder = $request->folder;
        $image = $request->image;
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');

        $localFile = 'assets/images/screenshots/'.$folder.$image;
        $serverFile = '/ScreenShots/' . $folder . '/' . $image;
        if (file_exists($localFile))
            unlink(realpath($localFile));

        ftp_delete($conn, $serverFile);

        return response()->json('success');
    }
}