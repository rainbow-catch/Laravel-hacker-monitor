<?php
/**
 * Created by PhpStorm.
 * User: R
 * Date: 11/28/2022
 * Time: 9:06 AM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class LicenseController extends Controller
{
    /**
     * Create a new controller instance.
     *<!--'Hola' => $this->cipherEncryption1($user->EndDate),-->
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('license');
    }

    public function generateKey ($org, $key, $keydiv, $val) {
        $res = '';
        $newv = 0;
        for ($i = 0 ; $i < 4 ; $i ++) {
            for ($j = 0 ; $j < 4; $j++) {
                $orgChr = 0;
                $valChr = 0;
                if (strlen($org) > 0) {
                    $oi = ($i * 4 + $j) % strlen($org);
                    $orgChr = $org[$oi];
                }
                if (strlen($val) > 0) {
                    $vi = ($i * 4 + $j) % strlen($val);
                    $valChr = $val[$vi];
                }
                $newv = ($newv * $key + ord($orgChr)^ord($valChr)) % $keydiv;

                $res .= dechex($newv%16);
            }
            if ($i < 3)
                $res.='-';
        }
        return $res;
    }

    function write_php_ini($array, $file)
    {
        $res = array();
        foreach($array as $key => $val)
        {
            if(is_array($val))
            {
                $res[] = "[$key]";
                foreach($val as $skey => $sval)
                    $res[] = "$skey = ".$sval;
            }
            else
                $res[] = "$key = ".$val;
        }
        $this->safefilerewrite($file, implode("\r\n", $res));
    }

    function safefilerewrite($fileName, $dataToSave)
    {
        if ($fp = fopen($fileName, 'w'))
        {
            $startTime = microtime(TRUE);
            do
            {
                $canWrite = flock($fp, LOCK_EX);
                // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                if(!$canWrite) usleep(round(rand(0, 100)*1000));
            } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

            //file was locked so now we can store information
            if ($canWrite)
            {
                fwrite($fp, $dataToSave);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }

    public function xorString ($str, $key = 0x12) {
        $len = strlen($str);
        $res = '';
        for ($i = 0 ; $i < $len ; $i ++)
            $res .= chr(ord($str[$i])^$key);
        return $res;
    }

    function cipherEncryption1( $message)
    {
        $key = 47;
        $encryptText1 = '';
        for ($i = 0; $i < strlen($message); $i++){
            $temp = ord($message[$i]) + $key;
            if(ord($message[$i]) == 32){
                $encryptText1 .= " ";
            } else if ($temp > 126){
                $temp -= 94;
                $encryptText1 .= chr($temp);
            } else {
                $encryptText1 .= chr($temp);
            } // if-else
        } // for
        return $encryptText1;
    }

    function cipherEncryption4($message){
        $key = 54;
        $encryptText4 = '';
        for ($i = 0; $i < strlen($message); $i++)
        {
            $temp = ord($message[$i]) + $key;
            if(ord($message[$i]) == 32){
                $encryptText4 += " ";
            } else if ($temp > 126){
                $temp -= 94;
                $encryptText4 .= chr($temp);
            } else {
                $encryptText4 .= chr($temp);
            } // if-else
        }

	    return $encryptText4;
    }
    function cipherEncryption44($message){
        $key = 11;
        $encryptText44 = '';
        for ($i = 0; $i < strlen($message); $i++)
        {
            $temp = ord($message[$i]) + $key;
            if(ord($message[$i]) == 32){
                $encryptText44 += " ";
            } else if ($temp > 126){
                $temp -= 94;
                $encryptText44 .= chr($temp);
            } else {
                $encryptText44 .= chr($temp);
            } // if-else
        }

	    return $encryptText44;
    }

    public function generate (Request $request) {
        $zip = new ZipArchive;
        $zipFile = "Xor_License.zip";
        $license = "ClientInfo.ini";
        $xmlFile = "Special.xml";
        if (file_exists($zipFile))
            unlink($zipFile);
        if (file_exists($license))
            unlink($license);
        if (file_exists($xmlFile))
            unlink($xmlFile);
 
        $conn = $this->checkFtp($request);
        if ($conn == null)
            return redirect('/ftp');
        $user = Auth::user();

        $data = array(
            'ClientInfo' => array(
                'ClientName' => $request->client_name,
                'XorF' => $this->cipherEncryption1($request->session()->get('ftpaddress')),
                'XorU' => $this->cipherEncryption1($request->session()->get('ftpusername')),
                'XorP' => $this->cipherEncryption1($request->session()->get('ftppassword')),
                'SpecialCode' => $this->cipherEncryption1($user->ip),
                'CheckMemo' => $request->check_memo == "on" ? 0 : 0,
                'ForceLauncher' => $request->force_launcher == "on" ? 1 : 0,
                'LauncherCRC' => $request->launcher_crc,
                'Macros' => $request->checksumm == "on" ? 0 : 0,
                'MaxInstances' => $request->max_instances,
                'Version' => $this->cipherEncryption44($user->enddate),
                'Crc32' => 0
            ),
        );
  
        $this->write_php_ini($data, $license);
        
        @file_put_contents($xmlFile,$this->cipherEncryption4($user->ip));
      

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE)
        {
          
            $zip->addFile($license, $license);
            $zip->addFile($xmlFile, $xmlFile);
           
            $zip->close();
        }
        return response()->file($zipFile, [
            'Content-Disposition' => 'attachment; filename=' . '"' . $zipFile . '"'
        ]);
    }
    
}
