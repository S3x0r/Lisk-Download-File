<?php

error_reporting(0);

ini_set('precision', 25);

define('N', PHP_EOL);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    chdir('../');
    $GLOBALS['OS'] = 'WIN';
}

/* search for incomplete files */
if ($result = glob("tempfile_*")) {
    $file = explode('_', implode('', $result));
    $GLOBALS['resumed_file'] = $file[0].'_'.$file[1];
    $GLOBALS['resumed_meta'] = $file[1];
    $GLOBALS['resumed_tx'] = file_get_contents('temptx');
}

echo '
 B@B@B@B@@@B@B@B@B@B@B@B@@@B@B@B@B@B@@@@@@@B@B@B@B@B@@@B@B
 @B@BGB@B@B@B@B@@@B@@@B@B@B@@@B@B@B@B@B@@@B@B@B@@@B@@@@@B@
 B@B@  :@Bi:@B@B@B@@@B@BGS522s22SXMB@B@B@B@B@B@B@B@@@B@B@B
 @: r   :   H@B@B@B@9sr;rrs5ssss2H2229M@@@B@B@B@B@B@B@B@@@
 B         S@B@@@B,      ,::rsGB5:,  ,:i9@@B@B@B@B@B@, B@B
 @B@M,     @B@X@X   rMB@Mr:,:MS          iB@B@B2  B@   @@@
 B@@@B@    :@BGB  sB@B@;sBBrii  rB@B@B2:, :B@B@i         s
 @@@B@@@ii:sB@9X ,@@B,    BSi  9Bi ,B@B@r,  M@B@B        S
 B@@@B@B@92,@9,X  @B@,   ,@2i  @     B@GX:,  B@@,     X@@B
 @B@@@B@BMs:r@r;i i@B@G2M@S::, @s  ,X@G92,   ,B@    B@B@B@
 @@B@B@M@B2r:sssr: i29@B5i,  r :@B@B@BXr,,   ,@;::rM@B@B@B
 @B@B@B@B@Gs:rHSSsi:,,,,     ,:,,rssri,,,iir,9s  rB@B@B@B@
 B@B@B@B@B@si:XSSSsrsi::,,,::,:::,,,, ,,:;rsr,  :B@B@B@B@B
 @B@B@B@@@BG: :XXG: :rssssS3x0rS2ssr::irrrrrr  ,B@B@B@B@B@
 B@B@B@B@B@Bs  :SGM                 :rrrsr,    G@B@@@B@B@@
 @B@@@B@B@B@Xs  :SM@               ,ssss,     r@B@B@B@B@B@
 B@B@B@@@B@B2Hs  :SM@@sr:,      :sMG22s,   ,r:@@@B@B@B@B@B
 @B@B@B@B@B@2s9s,  ,::r222sHSX222srri:   ,rrirB@B@B@B@B@B@
 B@B@B@B@B@B2s292                       :rri:2@B@B@B@B@B@B
 @B@B@B@@@B@Ss29s,  ,, ,         ,     rrrii,M@@B@@@B@B@B@
 B@B@B@B@B@@MsXGs,,,,, ,,:i:,,,       ,ssrriiB@B@B@@@B@B@B
 @B@B@B@@@B@r:r5r ,,,, ,,,,, ,,       ,rii:,,@B@B@@@B@B@B@
 B@B@B@B@B@@:   ,,:,,,,          ,,          G@@@B@B@B@B@B
 @B@B@B@B@B@B   ,,,,,,,,   ,                X@B@B@B@B@B@@@
 B@B@B@B@B@B@B        , , ,,               9@B@B@B@B@B@B@B
 @B@B@@@B@B@B@Br                         i@@B@B@B@B@B@B@B@
 B@B@B@B@B@@@B@B@Br:                  rM@B@B@B@B@B@B@B@B@@
 @B@B@B@B@@@B@B@@@B@B@2           :GB@BBG9XXSSS9X9999G9GGM
 B@B@@@B@B@B@B@@@B@B@@s           Srri;i;rrrssssssss22S5HS
 @B@B@B@B@B@BBMMGG9G:              :,::::iir;rs22SXGGMMMMB'.N.N;

echo ' Lisk Download 0.5 (download file from lisk blockchain)'.N;
echo ' by minionsteam.org, phoenix1969, sexor, zOwn3d'.N;
echo ' ------------------------------------------------------'.N;

if (!isset($GLOBALS['resumed_file'])) {
    echo N.' Transaction ID: ';

    $answer = Interact();

    if (!empty($answer)) {
        $GLOBALS['meta_tx'] = $answer;
        GetMetaData($answer);
    } else {
             echo ' You need to write transaction tx! Exiting.'.N;
             WinSleep(3);
             die();
    }
} else {
         GetMetaData($GLOBALS['resumed_meta']);
}
//---------------------------------------------------------------------------------------------------
function GetMetaData($txId)
{
    global $tx_filename;

    /* get tx data */
    $handle = file_get_contents('https://testnet.lisk.io/api/transactions?id='.$txId.'&limit=1&offset=0');
    $rawData = json_decode($handle, true);

    $data = $rawData['data']['0']['asset']['data'];

    /* decode it */
    $base91 = new Base91();
    $decodedData = $base91->decode($data);

    $rawMeta = explode("'", $decodedData);

    if (!isset($GLOBALS['resumed_meta'])) {
        echo N.' Checking Transaction: '.$txId.N.N;
    }

    /* check if valid header */
    if ($rawMeta[0] == 'M') {
        $tx_filename  = $rawMeta[1];
        $GLOBALS['tx_size'] = $rawMeta[2];
        $tx_lastBlock = toDec($rawMeta[3]);

        echo ' Filename : '.$tx_filename.N;
        echo ' Size     : '.formatBytes($GLOBALS['tx_size']).N;
        echo ' File TX  : '.$tx_lastBlock.N;
        
        /* restore file */
        if (!isset($GLOBALS['resumed_meta'])) {
            echo N.' Download file? (yes/no): ';
            $answer = Interact();

            if ($answer == 'yes' xor $answer == 'y') {
                echo N.' Downloading file from Lisk blockchain:'.N;
                GetData(toDec($rawMeta[3]));
            } else {
                     echo ' Exiting...'.N;
                     WinSleep(3);
            }
        } else {
                 echo N.' Do you want to resume downloading previous file? (yes/no): ';

                 $answer = Interact();
                
            if ($answer == 'yes' xor $answer == 'y') {
                echo N;
                ResumeData($GLOBALS['resumed_tx']);
            } else {
                     unlink('temptx');
                     unlink($GLOBALS['resumed_file']);
                          
                     echo ' Exiting. '.N;
                     WinSleep(3);
            }
        }
    } else {
             echo ' No file in that transaction, Exiting.'.N;
             WinSleep(10);
    }
}
//---------------------------------------------------------------------------------------------------
function WinSleep($time)
{
    if (isset($GLOBALS['OS'])) {
        sleep($time);
    }
}
//---------------------------------------------------------------------------------------------------
function Interact()
{
    while ($ask = fgets(STDIN)) {
           break;
    }
    $ask = trim($ask);

    return $ask;
}
//---------------------------------------------------------------------------------------------------
function GetData($tx)
{
    $handle = file_get_contents('https://testnet.lisk.io/api/transactions?id='.$tx.'&limit=1&offset=0');
    $rawData = json_decode($handle, true);

    $data = $rawData['data']['0']['asset']['data'];
  
    $dataParts = explode("'", $data);
    
    $data_part = $dataParts[0];
    
    if (isset($dataParts[1])) {
        $next_tx = toDec($dataParts[1]);
    }

    /* show data left */
    if (is_file('tempfile_'.$GLOBALS['meta_tx'])) {
        clearstatcache();
        $left = formatBytes($GLOBALS['tx_size'] - filesize('tempfile_'.$GLOBALS['meta_tx']));
        echo ' Remaining: '.$left.N;
    }
    
    if (!empty($next_tx)) {
        file_put_contents('tempfile_'.$GLOBALS['meta_tx'], $data_part."'", FILE_APPEND);
        file_put_contents('temptx', $next_tx);
    } else {
             file_put_contents('tempfile_'.$GLOBALS['meta_tx'], $data_part."'", FILE_APPEND);
             $exp = explode("'", file_get_contents('tempfile_'.$GLOBALS['meta_tx']));

             /* reverse */
             $reverse = array_reverse($exp);
           
             /* remove empty */
             $exp2 = array_filter($reverse);
           
             /* convert to string */
             $imp = implode('', $exp2);

             /* decode */
             $Func = new Base91();
             $decoded = $Func->decode($imp);

             /* save to file */
             file_put_contents('tempfile_'.$GLOBALS['meta_tx'], $decoded);

             /* unzip */
             echo N.' Decompressing file...';
             $zip = new ZipArchive;
             $zip->open('tempfile_'.$GLOBALS['meta_tx']);
             $zip->extractTo(dirname(__FILE__).DIRECTORY_SEPARATOR);
             $zip->close();

             /* rename to file from meta data */
             unlink('tempfile_'.$GLOBALS['meta_tx']);

             /* delete temp_tx */
             unlink('temptx');

             echo N.N.' Done, File saved to: '.$GLOBALS['tx_filename'].N;
             WinSleep(7);
             die();
    }
    GetData($next_tx);
}
//---------------------------------------------------------------------------------------------------
function ResumeData($tx)
{
    $handle = file_get_contents('https://testnet.lisk.io/api/transactions?id='.$tx.'&limit=1&offset=0');
    $rawData = json_decode($handle, true);

    $data = $rawData['data']['0']['asset']['data'];
  
    $dataParts = explode("'", $data);
    
    $data_part = $dataParts[0];

    if (isset($dataParts[1])) {
        $next_tx = toDec($dataParts[1]);
    }
    
    if (is_file('tempfile_'.$GLOBALS['resumed_meta'])) {
        clearstatcache();
        $left = formatBytes($GLOBALS['tx_size'] - filesize($GLOBALS['resumed_file']));
        echo ' Remaining: '.$left.N;
    }

    if (!empty($next_tx)) {
        file_put_contents('tempfile_'.$GLOBALS['resumed_meta'], $data_part."'", FILE_APPEND);
        file_put_contents('temptx', $next_tx);
    } else {
             file_put_contents($GLOBALS['resumed_file'], $data_part."'", FILE_APPEND);
             $exp = explode("'", file_get_contents($GLOBALS['resumed_file']));

             /* reverse */
             $reverse = array_reverse($exp);
           
             /* remove empty */
             $exp2 = array_filter($reverse);
           
             /* convert to string */
             $imp = implode('', $exp2);

             /* decode */
             $Func = new Base91();
             $decoded = $Func->decode($imp);

             /* save to file */
             file_put_contents($GLOBALS['resumed_file'], $decoded);
  
             /* unzip */
             echo N.' Decompressing file...';
             $zip = new ZipArchive;
             $zip->open($GLOBALS['resumed_file']);
             $zip->extractTo(dirname(__FILE__).DIRECTORY_SEPARATOR);
             $zip->close();

             /* delete temp data */
             unlink($GLOBALS['resumed_file']);
             unlink('temptx');
            
             echo N.N.' Done, File saved to: '.$GLOBALS['tx_filename'].N;
             WinSleep(7);
             die();
    }
    ResumeData($next_tx);
}
//---------------------------------------------------------------------------------------------------
function formatBytes($size, $precision = 0)
{
    $unit = ['Byte(s)','KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];

    for ($i = 0; $size >= 1024 && $i < count($unit)-1; $i++) {
         $size /= 1024;
    }

    return round($size, $precision).' '.$unit[$i];
}
//---------------------------------------------------------------------------------------------------
function toDec($hex)
{
    if (strlen($hex) == 1) {
        return hexdec($hex);
    } else {
             $remain = substr($hex, 0, -1);
             $last = substr($hex, -1);
             return bcadd(bcmul(16, toDec($remain)), hexdec($last));
    }
}
//---------------------------------------------------------------------------------------------------
class Base91
{
    private static $chars = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '#', '$',
        '%', '&', '(', ')', '*', '+', ',', '.', '/', ':', ';', '<', '=',
        '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~', '"'
    );

    public static function decode($input)
    {
        if (is_array($input)) {
            $input = $input[0];
        }

        $charset = array_flip(self::$chars);

        $b = $n = $return = null;
        $len = strlen($input);
        $v = -1;
        for ($i = 0; $i < $len; ++$i) {
            $c = @$charset[$input{$i}];
            if (!isset($c)) {
                continue;
            }
            if ($v < 0) {
                $v = $c;
            } else {
                $v += $c * 91;
                $b |= $v << $n;
                $n += ($v & 8191) > 88 ? 13 : 14;
                do {
                    $return .= chr($b & 255);
                    $b >>= 8;
                    $n -= 8;
                } while ($n > 7);
                $v = -1;
            }
        }
        if ($v + 1) {
            $return .= chr(($b | $v << $n) & 255);
        }
        return $return;
    }

    public static function encode($input)
    {
        if (is_array($input)) {
            $input = $input[0];
        }

        $b = $n = $return = null;
        $len = strlen($input);
        for ($i = 0; $i < $len; ++$i) {
            $b |= ord($input{$i}) << $n;
            $n += 8;
            if ($n > 13) {
                $v = $b & 8191;
                if ($v > 88) {
                    $b >>= 13;
                    $n -= 13;
                } else {
                    $v = $b & 16383;
                    $b >>= 14;
                    $n -= 14;
                }
                $return .= self::$chars[$v % 91] . self::$chars[$v / 91];
            }
        }
        if ($n) {
            $return .= self::$chars[$b % 91];
            if ($n > 7 || $b > 90) {
                $return .= self::$chars[$b / 91];
            }
        }
        return $return;
    }
}
