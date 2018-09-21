<?php
error_reporting(0);
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    chdir('../');
}

echo '
                                                   F                      
                                                  q@B                     
                                                 u@B@O                    
                                                7@BBB@X                   
                                               7@BBOMB@u                  
                                               8B@MMOMB@7                 
                                                OB@MMOMB@i                
                                             E   BBBMMOBB@,               
                                            @BX   @BBOMOBB@               
                                           OB@BY   @BBOMMB@@              
                                          NB@M@@r  .@@BMMMBB@             
                                         uB@MMM@Br  :@BMOMM@BM            
                                        7@@MMOBB@O   r@BMOMM@B0           
                                       iB@MMOMB@O     j@BMOMO@B2          
                                      :B@MMOMM@B       S@BMOMM@Bv         
                                      B@MMOMM@B         G@BMOMM@@i        
                                     B@MMOMM@B           M@MMOMM@B:       
                                    B@MMOMM@B,            @@MMOMM@B.      
                                   8@BMOMM@@i              @@MMOMM@B      
                                  X@BMOMM@B7               .B@MMOMM@B     
                                 u@BMOMO@Bu                 :B@MMOMB@O    
                                7@BMOMM@BP                   7B@MMOMB@q   
                               i@@BOMMBBO                     jB@MMOMB@2  
                              ,@@MOMOMBE                       JBMOMOMB@L 
                             :@BBMMOMM@                         @BMOMMBB@J
                             rB@BBOMOMB@:                     .MBMOMOMB@B1
                               8@@BOMOMB@F                   7@BBMMOMB@B, 
                                L@B@MMMMB@B.                E@BMMMMBB@P   
                                 .@B@MMOMB@@7             :B@BMOMM@@@r    
                                   NB@MMOMM@B0vJJuuqZ,   JB@MMOMM@B@      
                                    7B@MMMMM@B@B@B@B7   MB@MMOMM@@F       
                                     .@@BMOMMMMBB@Z   :@B@MMOBB@@i        
                    ......,.,...       F@BBMMOMM@B. .u@B@MBMBB@M          
                .,,,.........,.,,:..    i@B@MBMMZGrMB@B@B@@@B@u           
             .,:,.... . ... ......,,:.    M@@OZU1P@@M2F25255X:            
           .::...        ,,:...  ......    rSBEPPMB5                      
          ,,...  .iLSkkuv::ir;,,.     .,.     MOMB2                       
           ... .:1O8j7ii7jvi. ,ELLXkFF25ku   jBBBP
     ,r7v;:.,,,i5Mu.      :Li :uPv@BBZqkXNv  rOB@7
  .iuGZkuuJJ7:iLEk    7u:  :jirXGrX@PUv7i:,   .r. 
 .7FMj:     :LLrOi   SBBB.  YJ7jMUri,.,.,.,  .::
 7JML     7i .v;5i   jZSL   LFi77Fi:,::::::. :i:
,75E.   :S@Bv r7rr         :57r7Y7::::i::::,:,r 
,vuP    .8Zki iYrrr.      ,J;vFSLi::::::::.:,:i 
 r7U,     .   vr,:r7i,..,iv:iPSLi:::::::i7J:,i. 
 ,7v7.       i7:vi.:iriiiiiJuLri::::,,i5E@M:.i  
  ,rvvi.. ..ri,u@EY;i:::i7L7rri::::.:uZMMM7 ::  
   .:r77riii:ij5r::::iii::.;YSi::,,7Z@8Fvr.,:u. 
      ,,::::rri.....,..7jLkB@P,:,:2GBZ7.,,,::i. 
      i::::::FLv;rjMZqG@B@B@O...iXOOFi.,,::i:,  
      L:.,,.:O@B@B@B@B@B@B@L  .7EZZL:.:::::i::  
      jJ ..,. :1M@B@B@BOu:   .JO8ki..::::::i::  
      ,qi         ...    .:rjSOqF:.,::::::::::. 
       YS:.,,i:i:;i;r7u5S0SJE@81...::::::::::i. 
       .u8P2XSSSFFqPkSPFFuuJu2q5,.,,::::::::::, 
       ..S85U2jU21U2UujuUuJ1uU5Sr..:::::::::,:. 
       ...UuuJJLYv7;vvYLu2U1FU251:....,,,::::r7 
       ...vUJYYuLv7LvJvLYSLuuuJ1jv::ir;7vYLUUXB,
       .:.ruJLLJJLjLuujJF2JLjuuuSuqUXkkjqNkF5SF 
       .7J7uvYYju1uF55U5UjujLjYuSuuNFPSY1qPkFP. 
        :uuvLLJLuu2UuLjjUuuYU1U7LvYuS11ukXXNGi  
      .GkFrLjUYJLjYuvvuUYuuuUFu2Juu1215NNGON,   
       E@BF7JUFSXSF21JFFFFS151kXPkF5q0MM@Ov     
       2BM@MFUF0GONX55u150OOZqkPkNqMB@85:       
       J@OOB@B@: :8O0PN0BqjLX@OGOO@Mi           
        E@@@BG    :BB@B@M    @BO8MO             
         :S@@7   JEB@B@BJ    .@B@Bv             
                0@@@B@B@@vii:EB@B@BZ';

echo PHP_EOL.PHP_EOL.' Download File from Lisk blockchain'.PHP_EOL.PHP_EOL;
echo PHP_EOL.' Transaction ID: ';

while ($tx = fgets(STDIN)) {
    break;
}

$tx = trim($tx);

if (!empty($tx)) {
    GetMetaData($tx);
} else {
         echo ' You need to write transaction tx! Exiting.';
         sleep(3);
         die();
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

    echo PHP_EOL.' Checking Transaction: '.$txId.PHP_EOL;

    /* check if valid header */
    if ($rawMeta[0] == 'M') {
        $tx_filename  = $rawMeta[1];
        $tx_size      = $rawMeta[2];
        $tx_lastBlock = $rawMeta[3];

        echo ' Filename : '.$tx_filename.PHP_EOL;
        echo ' Size     : '.$tx_size.'b'.PHP_EOL;
        echo ' File ID  : '.$tx_lastBlock.PHP_EOL;
        
        sleep(2);

        echo PHP_EOL.' Restoring File from Lisk blockchain...'.PHP_EOL.PHP_EOL;

        /* restore file */
        echo ' Data:'.PHP_EOL;
        GetData($rawMeta[3]);
    } else {
             echo PHP_EOL.' Cannot find file header, aborting.';
             sleep(40);
    }
}
//---------------------------------------------------------------------------------------------------
function GetData($tx)
{
    $handle = file_get_contents('https://testnet.lisk.io/api/transactions?id='.$tx.'&limit=1&offset=0');
    $rawData = json_decode($handle, true);

    $data = $rawData['data']['0']['asset']['data'];
  
    $dataParts = explode("'", $data);
    
    $data_part = $dataParts[0];
    $next_tx = $dataParts[1];

    /* show data flow */
    echo $data_part;
   
    if (!empty($next_tx)) {
        file_put_contents('temp_file', $data_part."'", FILE_APPEND);
    } else {
             file_put_contents('temp_file', $data_part."'", FILE_APPEND);
             $exp = explode("'", file_get_contents('temp_file'));

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
             file_put_contents('temp_file', $decoded);

             /* rename to file from meta data */
             rename('temp_file', $GLOBALS['tx_filename']);
           
             echo PHP_EOL.PHP_EOL.' Done, Data saved to file: '.$GLOBALS['tx_filename'].PHP_EOL;
             die();
    }
    GetData($next_tx);
}


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
