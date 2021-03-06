<?php

error_reporting(0);
ini_set('precision', 25);
define('N', PHP_EOL);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    !isset($_SERVER['argv'][2]) ? chdir('../') : false;

    $GLOBALS['OS'] = 'WIN';
}

if (isset($_SERVER['argv'][2])) {
    unlink('tempfile_');
    unlink('temptx');
}

/* search for incomplete files */
if ($result = glob("tempfile_*")) {
    $file = explode('_', implode('', $result));
    $GLOBALS['resumed_file'] = $file[0].'_'.$file[1];
    $GLOBALS['resumed_meta'] = $file[1];
    $GLOBALS['resumed_tx'] = file_get_contents('temptx');
}

if (!isset($_SERVER['argv'][2])) {
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

    echo " Lisk Download 1.2 (download file from lisk blockchain)\n".
         " by minionsteam.org, phoenix1969, minions\n".
         " ------------------------------------------------------\n";
}

if (isset($_SERVER['argv'][1])) {
    GetMetaData(trim($_SERVER['argv'][1]));
} else {
    if (!isset($GLOBALS['resumed_file'])) {
        echo "\n 1 - Download file\n".
             " 2 - Scan lisk wallet address\n\n".
             " [1/2]: ";

        $answer = Interact();

        /* if download choosed */
        if ($answer == '1') {
            echo "\n Transaction ID: ";
            $answer = Interact();
            
            if (!empty($answer)) {
                $GLOBALS['meta_tx'] = $answer;
                GetMetaData($answer);
            } else {
                     echo " You need to write transaction tx! Exiting.\n";
                     WinSleep(3);
                     exit;
            }
        }
        
        /* if scan address choosed */
        if ($answer == '2') {
            echo "\n Lisk wallet address: ";
            $answer = Interact();

            if (!empty($answer) && preg_match('/^[0-9]+[L]$/', $answer)) {
                ScanAddress($answer);
            } else {
                     echo " You need to write Lisk address! Exiting.\n";
                     WinSleep(3);
                     exit;
            }
        }

        if (!in_array($answer, ['1', '2'], true)) {
            echo "\n Bad choice! Exiting.";
            WinSleep(3);
            exit;
        }
    } else {
         GetMetaData($GLOBALS['resumed_meta']);
    }
}
//---------------------------------------------------------------------------------------------------
function GetMetaData($txId)
{
    global $tx_filename;

    /* get tx data */
    $rawData = json_decode(file_get_contents("https://testnet.lisk.io/api/transactions?id={$txId}&limit=1&offset=0"), true);

    $rawMeta = explode("'", Base91::decode($rawData['data']['0']['asset']['data']));

    if (!isset($GLOBALS['resumed_meta'])) {
        echo "\n Checking Transaction: {$txId}\n\n";
    }

    /* check if valid header */
    if ($rawMeta[0] == 'M') {
        $tx_filename  = $rawMeta[1];
        $GLOBALS['tx_size'] = $rawMeta[2];
        $tx_lastBlock = toDec($rawMeta[3]);

            echo " Filename : {$tx_filename}\n".
                 " Size     : ".formatBytes($GLOBALS['tx_size']).
                 "\n File TX  : {$tx_lastBlock}\n";

        /* restore file */
        if (!isset($GLOBALS['resumed_meta'])) {
            if (!isset($_SERVER['argv'][2])) {
                echo "\n Download file? (yes/no): ";

                $answer = Interact();

                if ($answer == 'yes' xor $answer == 'y') {
                    echo "\n Downloading file from Lisk blockchain:\n";
                    GetData(toDec($rawMeta[3]));
                } else {
                         echo " Exiting...\n";
                         WinSleep(3);
                }
            } else {
                     GetData(toDec($rawMeta[3]));
            }
        } else {
                 echo "\n Do you want to resume downloading previous file? (yes/no): ";

                 $answer = Interact();
                
            if ($answer == 'yes' xor $answer == 'y') {
                echo N;
                GetData($GLOBALS['resumed_tx']);
            } else {
                     unlink('temptx');
                     unlink($GLOBALS['resumed_file']);
                          
                     echo " Exiting.\n";
                     WinSleep(3);
            }
        }
    } else {
             echo " No file in that transaction, Exiting.\n";
             WinSleep(10);
    }
}
//---------------------------------------------------------------------------------------------------
function WinSleep($time)
{
    if (!isset($_SERVER['argv'][2])) {
        isset($GLOBALS['OS']) ? sleep($time) : false;
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
    $rawData = json_decode(file_get_contents("https://testnet.lisk.io/api/transactions?id={$tx}&limit=1&offset=0"), true);

    $dataParts = explode("'", $rawData['data']['0']['asset']['data']);
    
    isset($dataParts[1]) ? $next_tx = toDec($dataParts[1]) : false;

    printProgress();
    
    if (!empty($next_tx)) {
        isset($GLOBALS['resumed_tx']) ? $meta = $GLOBALS['resumed_meta'] : $meta = $GLOBALS['meta_tx'];

        file_put_contents('tempfile_'.$meta, $dataParts[0]."'", FILE_APPEND);
        file_put_contents('temptx', $next_tx);
    } else {
        if (isset($GLOBALS['resumed_tx'])) {
            file_put_contents($GLOBALS['resumed_file'], $dataParts[0]."'", FILE_APPEND);
            $exp = explode("'", file_get_contents($GLOBALS['resumed_file']));
        } else {
                 file_put_contents('tempfile_'.$GLOBALS['meta_tx'], $dataParts[0]."'", FILE_APPEND);
                 $exp = explode("'", file_get_contents('tempfile_'.$GLOBALS['meta_tx']));
        }

        /* reverse */
        $reverse = array_reverse($exp);
         
        /* remove empty */
        $exp2 = array_filter($reverse);
         
        /* convert to string */
        $imp = implode('', $exp2);

        /* save to file */
        isset($GLOBALS['resumed_tx']) ? file_put_contents($GLOBALS['resumed_file'], Base91::decode($imp)) :
                                        file_put_contents('tempfile_'.$GLOBALS['meta_tx'], Base91::decode($imp));

        echo "\n Decompressing file...";

        /* unzip */
        $zip = new ZipArchive();
        isset($GLOBALS['resumed_tx']) ? $zip->open($GLOBALS['resumed_file']) : $zip->open('tempfile_'.$GLOBALS['meta_tx']);

        $zip->extractTo(dirname(__FILE__).DIRECTORY_SEPARATOR);
        $zip->close();

        /* delete temp_tx */
        unlink($GLOBALS['resumed_file']);
        unlink('tempfile_'.$GLOBALS['meta_tx']);
        unlink('temptx');

        echo "\n\n Done, File saved to: {$GLOBALS['tx_filename']}\n";
        
        WinSleep(7);
        exit;
    }

    GetData($next_tx);
}
//---------------------------------------------------------------------------------------------------
function ScanAddress($address)
{
    echo "\n Minions scanning address for files. Please wait...\n";

    $offset = '0';
    $counter = '1';
    $list = [''];

    while (1) {
        $raw = json_decode(file_get_contents("https://testnet.lisk.io/api/transactions?senderIdOrRecipientId={$address}&limit=100&offset={$offset}&sort=amount%3Adesc"), true);

        $total = $raw['meta']['count'];

        if ($total != '0' && $offset != $total) {
            foreach ((array) $raw['data'] as $id) {
                if (isset($id['asset']['data'])) {
                    $decoded = Base91::decode($id['asset']['data']);
               
                    if (preg_match("/[M]'(.*)'(.*)'(.*)/", $decoded)) {
                        $meta = explode("'", $decoded);
                        array_push($list, $id['id']);
                        echo " ({$counter}) File: {$meta[1]}, size: ".formatBytes($meta[2]).
                             ", tx: {$id['id']}\n";
                        $counter++;
                    }
                }
                   $offset++;
            }

            if ($offset == $total && !empty(array_filter($list))) {
                echo "\n --------------------------------------------------\n".
                     " Which file do you want to download? ";

                $answer = Interact();

                if (!empty($answer)) {
                    if (is_numeric($answer)) {
                        if (count($list) > $answer) {
                            $GLOBALS['meta_tx'] = $list[$answer];
                            GetMetaData($list[$answer]);
                        } else {
                                 echo ' Wrong file number! Exiting.';
                                 WinSleep(10);
                                 exit;
                        }
                    } else {
                        echo ' Wrong file number! Exiting.';
                        WinSleep(10);
                        exit;
                    }
                } else {
                         echo ' Wrong file number! Exiting.';
                         WinSleep(10);
                         exit;
                }
            }
        } else {
                 echo ' No files found in this wallet, Exiting.';
                 WinSleep(10);
                 exit;
        }
    }
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
function printProgress() /* print how much data left */
{
    clearstatcache();

    is_file('tempfile_'.$GLOBALS['resumed_meta']) ? $left = formatBytes($GLOBALS['tx_size'] - filesize($GLOBALS['resumed_file'])) :
                                                    $left = formatBytes($GLOBALS['tx_size'] - filesize('tempfile_'.$GLOBALS['meta_tx']));

    echo " Remaining: {$left}\r";

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
