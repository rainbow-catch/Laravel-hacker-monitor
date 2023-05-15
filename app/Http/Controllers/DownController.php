<?php
/**
 * Created by PhpStorm.
 * User: R
 * Date: 9/19/2022
 * Time: 1:14 PM
 */

namespace App\Http\Controllers;

use App\Models\DownloadFile;
use App\Models\DownloadLog;
use http\Env\Response;
use Illuminate\Http\Request;
use Mockery\Exception;
use function Symfony\Component\Console\Input\hasArgument;

class DownController extends Controller
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
        $files = DownloadFile::get();
        $logs = DownloadLog::get();
        return view('download', [
            'files' => $files,
            'logs' => $logs
        ]);
    }

    public function save(Request $request, $id=null) {
        try {
            if($id==null) {
                $item = new DownloadFile();
            }
            else $item = DownloadFile::find($id);

            $item->name = $request->input('name');
            $item->description = $request->input('description');
            $item->path = $request->input('path');
            $item->update_date = $request->input('update_date');
            $item->save();
            return response()->json(['new'=>$id==null], 200);
        }
        catch (Exception $e){
            return response()->json('failed', 500);
        }
    }
    public function saveLog(Request $request, $id="") {
        try {
            if($id==""){
                $item = new DownloadLog([
                    "log" =>$request->input('log')
                ]);
                $item->save();
                return response()->json('success')->setData($item);
            }
            $item = DownloadLog::find($id);
            $item->log = $request->input('log');
            $item->save();
            return response()->json('success')->setData($item);
        }
        catch (Exception $e){
            return response()->json('failed');
        }
    }
    public function deleteLog($id) {
        try {
            if($id==""){
                return response()->json('failed');
            }
            DownloadLog::destroy($id);
            return response()->json('success');
        }
        catch (Exception $e){
            return response()->json('failed');
        }
    }
    public function delete($id) {
        try {
            if($id==""){
                return response()->json('failed');
            }
            DownloadFile::destroy($id);
            return response()->json('success');
        }
        catch (Exception $e){
            return response()->json('failed');
        }
    }

}
