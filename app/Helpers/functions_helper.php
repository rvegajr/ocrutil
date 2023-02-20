<?php

function Get($var, $default='') {
    if(!isset($_GET[$var])) return $default;
    return $_GET[$var];
}

function _strtotime($datetime, $baseTimestamp = null) {
    if ($datetime == null) return null;
    if ($baseTimestamp == null ) {
        return strtotime($datetime);
    } else {
        return strtotime($datetime, $baseTimestamp);
    }
}

// Declare the interface 'iTemplate'
interface IJQGridDataSource
{
    public function Count($where='');
    public function Query($sidx, $sord, $start, $limit, $where='');
    public function LastError();
}

function JQGridData($IJQGridDataSourceObject=null, $WhereCond="") {
    $count=0;
    $page = (isset($_REQUEST['page']) ? $_REQUEST['page']: 1); // get the requested page
    $limit = (isset($_REQUEST['rows']) ? $_REQUEST['rows']: 99999); // get how many rows we want to have into the grid
    $sidx = (isset($_REQUEST['sidx']) ? $_REQUEST['sidx']: '1'); // get index row - i.e. user click to sort
    $sord = (isset($_REQUEST['sord']) ? $_REQUEST['sord']: 'asc'); // get the direction
    $id = (isset($_REQUEST['id']) ? $_REQUEST['id']: -1); // get only 1 record,  if not set,  then set to -1 (which will return all rows in dfQuery)
    if (isset($_REQUEST['_search']) && $_REQUEST['_search']==true) {
        if(isset($_REQUEST['searchString']))
            $str=$_REQUEST['searchString'];
        else
            $str="";
        if ($str!=null && isset($_REQUEST['searchField'])) {
            $WhereCond=(strlen($WhereCond)>0 ? ' AND ' : '' ).$_REQUEST['searchField'];
            switch ($_REQUEST['searchOper']) {
                case "eq": //<option selected="selected" value="eq">equal</option>
                    $WhereCond.=" = ".escq($str);
                    break;
                case "ne": //option value="ne">not equal</option>
                    $WhereCond.=" != ".escq($str);
                    break;
                case "bw": //<option value="bw">begins with</option>
                    $WhereCond.=" LIKE ".escq($str.'%');
                    break;
                case "bn": //ption value="bn">does not begin with</option>
                    $WhereCond.=" NOT LIKE ".escq($str.'%');
                    break;
                case "ew": //option value="ew">ends with</option>
                    $WhereCond.=" LIKE ".escq('%'.$str);
                    break;
                case "en": //option value="en">does not end with</option>
                    $WhereCond.=" NOT LIKE ".escq('%'.$str);
                    break;
                case "cn": //option value="cn">contains</option>
                    $WhereCond.=" LIKE ".escq('%'.$str.'%');
                    break;
                case "nc": //option value="nc">does not contain</option>
                    $WhereCond.=" NOT LIKE ".escq('%'.$str.'%');
                    break;
                case "nu": //option value="nu">is null</option>
                    $WhereCond.=" IS NULL ";
                    break;
                case "nn": //option value="nn">is not null</option>
                    $WhereCond.="IS NOT NULL";
                    break;
                case "in": //<option value="in">is in</option>
                    $WhereCond.=" IN (".qimplode(",", explode(",", $str)).")";
                    break;
                case "ni": //<option value="ni">is not in</option></select>
                    $WhereCond.=" NOT IN (".qimplode(",", explode(",", $str)).")";
                    break;
            }
        }
    }
    $result =  (object)[];
    if(!$sidx) $sidx =1;

    if ( $id > -1 ) {
        $count=1;
        $page=1;
        $start=0;
        $total_pages=1;
        if (isset($IJQGridDataSourceObject)) {
            $result = $IJQGridDataSourceObject->Query($sidx, $sord, $start, $limit, $WhereCond);
            if ( !empty($IJQGridDataSourceObject->LastError()) ) ReturnErrorJSON( $IJQGridDataSourceObject->LastError(), 105 );
        }
    } else {
        if (isset($IJQGridDataSourceObject)) {
            $count = $IJQGridDataSourceObject->Count($WhereCond);
            if ( !empty($IJQGridDataSourceObject->LastError()) ) ReturnErrorJSON( $IJQGridDataSourceObject->LastError(), 106 );
        }

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if ( $start < 0 ) $start=0;

        if (isset($IJQGridDataSourceObject)) {
            $result = $IJQGridDataSourceObject->Query($sidx, $sord, $start, $limit, $WhereCond);
            if ( !empty($IJQGridDataSourceObject->LastError()) ) ReturnErrorJSON( $IJQGridDataSourceObject->LastError(), 107 );
        }
    }

    $response =  (object)[];
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;
    return array('response'=>$response,
        'result'=>$result,
        'start'=>$start,
        'limit'=>$limit,
        'sidx'=>$sidx,
        'sord'=>$sord,
        'id'=>$id
    );

}

function _debug($msg) {
    $msg=date('m/d/Y H:i:s').": ".BRtoNL($msg."\n");
    if ( !isset($GLOBALS['LOGFILENAME'])) return false;
    try {
        if ( !file_exists($GLOBALS['LOGFILENAME'])) {
            file_put_contents($GLOBALS['LOGFILENAME'], $msg);
        } else {
            file_put_contents($GLOBALS['LOGFILENAME'], $msg, FILE_APPEND | LOCK_EX);
        }
    } catch( Exception $e ) {
        $GLOBALS['LOGFILE_EXCEPTION']='Y';
        echo("CANNOT WRITE TO LOG FILE!  THIS APP WILL NO LONGER TRY TO TO WRITE TO IT FOR THIS RUN!\nLOG FILE NAME=".$GLOBALS['CALLLOG_LOG_FILENAME']."\n");
    }
    return true;
}

function WriteLog($msg) {
    $msg=date('m/d/Y H:i:s').":".BRtoNL($msg."\n");
    if ( isset($GLOBALS['LOGFILE_EXCEPTION'])) return false;
    try {
        if ( !file_exists($GLOBALS['LOGFILENAME'])) {
            file_put_contents($GLOBALS['LOGFILENAME'], $msg);
        } else {
            file_put_contents($GLOBALS['LOGFILENAME'], $msg, FILE_APPEND | LOCK_EX);
        }
    } catch( Exception $e ) {
        $GLOBALS['LOGFILE_EXCEPTION']='Y';
        echo("CANNOT WRITE TO LOG FILE!  THIS APP WILL NO LONGER TRY TO TO WRITE TO IT FOR THIS RUN OF THE MIGRATION UTILITY!\nLOG FILE NAME=".$GLOBALS['LOG_FILENAME']."\n");
    }
    return true;
}
//ZipPath('/folder/to/compress/', './compressed.zip');
function ZipPath($source, $destination) {
    try {
        $fileCount=0;
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                    $fileCount++;
                }
            }
        }
        else if (is_file($source) === true)
        {
            $zip->addFromString(basename($source), file_get_contents($source));
            $fileCount++;
        }

        $zip->close();
        return $fileCount;
    } catch( Exception $e ) {
        echo("CANNOT WRITE TO LOG FILE!  THIS APP WILL NO LONGER TRY TO TO WRITE TO IT FOR THIS RUN OF THE MIGRATION UTILITY!\nLOG FILE NAME=".$GLOBALS['LOG_FILENAME']."\n");
        return $e;
    }
}

//ZipPath('/folder/to/compress/', './compressed.zip');
function FileList($source, $baseurl) {
    try {
        $fileCount=0;
        $arr=array();

        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true)
                {
                    continue;
                }
                else if (is_file($file) === true)
                {
                    //$arr[]=str_replace($source . '/', '', $file). file_get_contents($file);
                    $arr[]=array("url"=>$baseurl.basename($file), "filename"=>basename($file));
                    $fileCount++;
                }
            }
        }
        /*
        else if (is_file($source) === true)
        {
            //$arr[]=basename($source).file_get_contents($file);
            //$zip->addFromString(basename($source), file_get_contents($source));
            //$fileCount++;
            continue;
        }*/

        return $arr;
    } catch( Exception $e ) {
        echo("CANNOT WRITE TO LOG FILE!  THIS APP WILL NO LONGER TRY TO TO WRITE TO IT FOR THIS RUN OF THE MIGRATION UTILITY!\nLOG FILE NAME=".$GLOBALS['LOG_FILENAME']."\n");
        return $e;
    }
}

function RenderSelectHTML($id, $arr, $valField='val', $textField='text', $selectedText = '', $unselectedText='') {
    $html="<select id='".$id."'>";
    if ( strlen($unselectedText) > 0 ) $html.="	<option value=''>".$unselectedText."</option>";
    foreach($arr as $item) {
        if ( $selectedText==$item[$textField]) {
            $html.="	<option value='".$item[$valField]."' selected>".$item[$textField]."</option>";
        } else {
            $html.="	<option value='".$item[$valField]."'>".$item[$textField]."</option>";
        }
    }
    $html.="</select>";
    return $html;

}
function ReturnError($e, $httpStatusMsg='', $httpStatusCode=400) {
    throw new Exception("This has been depracated, use the _this->versions instead as they work better with code igniter");
    return ReturnErrorJSON($httpStatusMsg,$httpStatusCode, null, $e);
}

function ReturnErrorJSON($ProcMessage='', $ErrorCode=400, $data=null, $e=null) {
    throw new Exception("This has been depracated, use the _this->versions instead as they work better with code igniter");
    //WriteLog('ERROR: '.$ProcMessage.' [Code='.$ErrorCode.']\n');
    log_message('error', "[ERROR] {$ProcMessage}", ['exception' => $e]);
    $backtrace = debug_backtrace();
    $response['code']=$ErrorCode;
    $response['message']=$ProcMessage;
    if ($data != null) {
        if (( is_array($data)) && ( count($data) > 0 )) {
            $response['data']=$data;
        } elseif ( strlen($data) > 0 ) {
            $response['data']=$data;
        }
    }
    $ts = gmdate("D, d M Y H:i:s") . " GMT";
    header("Expires: $ts");
    header("Last-Modified: $ts");
    header("Pragma: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: application/json; charset=UTF-8');

    $httpStatusCode = $ErrorCode;
    $httpStatusMsg  = 'Error: '.$ProcMessage. ' '. http_response_code_text($httpStatusCode);
    $phpSapiName    = substr(php_sapi_name(), 0, 3);
    if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
        header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
    } else {
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
        header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
    }
    exit( json_encode($response) );
}

function toMySQLDate($DataStr) {
    $datetime = strtotime($DataStr);
    return date("Y-m-d", $datetime);
}

function toMySQLDateTime($DataStr) {
    $datetime = strtotime($DataStr);
    return date("Y-m-d G:i:s", $datetime);
}


if (!function_exists('http_response_code_text')) {
    function http_response_code_text($code = NULL) {

        if ($code !== NULL) {

            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            $GLOBALS['http_response_code'] = $code;

        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $text;

    }
}

function ReturnOk($httpStatusMsg='', $httpStatusCode=200)
{
    throw new Exception("This has been depracated, use the _this->versions instead as they work better with code igniter");
    return ReturnMessageJSON('', -1, -1, '', $httpStatusCode, $httpStatusMsg );
}
function  ReturnMessageJSON($ProcMessage='', $id=-1, $action=-1, $data='', $httpStatusCode=200, $httpStatusMsg='') {
    throw new Exception("This has been depracated, use the _this->versions instead as they work better with code igniter");

    $response['code']=0;
    $response['message']=$ProcMessage;
    if ( $id > -1 ) $response['id']=$id;
    if ( $action > -1 ) $response['action']=$action;
    if (( is_array($data)) && ( count($data) > 0 )) {
        $response['data']=$data;
    } elseif ( strlen($data) > 0 ) {
        $response['data']=$data;
    }
    $ts = gmdate("D, d M Y H:i:s") . " GMT";
    header("Expires: $ts");
    header("Last-Modified: $ts");
    header("Pragma: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: application/json; charset=UTF-8');
    if (strlen($httpStatusMsg)==0) {
        $httpStatusMsg=http_response_code_text($httpStatusCode) ?? 'Code:'.$httpStatusCode;
    }
    $phpSapiName    = substr(php_sapi_name(), 0, 3);
    if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
        header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
    } else {
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
        header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
    }

    exit( json_encode($response) );
}


function contains($haystack, $needle, $case = false)
{
    if ($case)
    {
        $result = (strpos($haystack, $needle) !== false );
    }
    else
    {
        $result = (stripos($haystack, $needle) !== false );
    }

    return $result;
}

function _echo($msg) {
    _debug($msg."\n");
    echo nl2br($msg."\n");
}

function qimplode($glue, $pieces) {
    $str="'".implode("'".$glue."'", $pieces)."'";
    $str=str_ireplace("'NULL'", "NULL", $str);//STRIP Quotes off of NULL values
    return $str;
}

function genINSERT_SQL($tableName, $kvarray) {
    $keys=array_keys($kvarray);
    $vals=array_values($kvarray);
    for ($i = 0; $i < count($vals); $i++) {
        $vals[$i]=str_replace("'", "''", $vals[$i]);
    }
    return "INSERT INTO ".$tableName." (".implode(",", $keys).") values (".qimplode(",", $vals).")";
}

function BRtoNL($string){
    return PREG_REPLACE('#<br\s*?/?>#i', "\n", $string);
}


function isDateValid($str)
{
    $stamp = strtotime($str);
    if (!is_numeric($stamp))
        return FALSE;

    //checkdate(month, day, year)
    if ( checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)) )
    {
        return TRUE;
    }
    return FALSE;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

/**
 * Makes directory and returns BOOL(TRUE) if exists OR made.
 *
 * @param  $path string name
 * @return bool
 */
function rmkdir($path, $mode = 0777) {
    $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
    $e = explode("/", ltrim($path, "/"));
    if(substr($path, 0, 1) == "/") {
        $e[0] = "/".$e[0];
    }
    $c = count($e);
    $cp = $e[0];
    for($i = 1; $i < $c; $i++) {
        if(!is_dir($cp) && !@mkdir($cp, $mode)) {
            return false;
        }
        $cp .= "/".$e[$i];
    }
    return @mkdir($path, $mode);
}

function copySecureFile($FromLocation,$ToLocation,$VerifyPeer=false,$VerifyHost=true)
{
    // Initialize CURL with providing full https URL of the file location
    $Channel = curl_init($FromLocation);

    // Open file handle at the location you want to copy the file: destination path at local drive
    $File = fopen ($ToLocation, "w");

    // Set CURL options
    curl_setopt($Channel, CURLOPT_FILE, $File);

    // We are not sending any headers
    curl_setopt($Channel, CURLOPT_HEADER, 0);

    // Disable PEER SSL Verification: If you are not running with SSL or if you don't have valid SSL
    curl_setopt($Channel, CURLOPT_SSL_VERIFYPEER, $VerifyPeer);

    // Disable HOST (the site you are sending request to) SSL Verification,
    // if Host can have certificate which is nvalid / expired / not signed by authorized CA.
    curl_setopt($Channel, CURLOPT_SSL_VERIFYHOST, $VerifyHost);

    // Execute CURL command
    curl_exec($Channel);

    // Close the CURL channel
    curl_close($Channel);

    // Close file handle
    fclose($File);

    // return true if file download is successfull
    return file_exists($ToLocation);
}

function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str='';
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }

    return $str;
}

function isDate($d){
    $ret = false;
    $re_sep='[\/\-\.]';
    //$re_time='( (([0-1]?\d)|(2[0-3])):[0-5]\d)?';
    $re_time='( (([0-1]?\d)|(2[0-3])):[0-5]\d:[0-5]\d)';
    $re_d='(0?[1-9]|[12][0-9]|3[01])'; $re_m='(0?[1-9]|1[012])'; $re_y='(19\d\d|20\d\d)';

    if (!preg_match('!' .$re_sep .'!',$d)) $d=strftime("%d-%m-%Y %H:%M",$d);  #Convert Unix timestamp to EntryFormat

    if (preg_match('!^' .$re_d .$re_sep .$re_m .$re_sep .$re_y. $re_time. '$!',$d,$m))  #dd-mm-yyyy
        $ret = checkdate($m[2], $m[1], $m[3]);
    elseif (preg_match('!^' .$re_y .$re_sep .$re_m .$re_sep .$re_d. $re_time. '$!',$d,$m))  #yyyy-mm-dd
        $ret = checkdate($m[2], $m[3], $m[1]);
    elseif (preg_match('!^' .$re_m .$re_sep .$re_d .$re_sep .$re_y. $re_time. '$!',$d,$m))  #mm-dd-yyyy
        $ret = checkdate($m[1], $m[2], $m[3]);

    return $ret && strtotime($d);
}

function chmod_R($path, $filemode, $dirmode) {
    if (is_dir($path) ) {
        if (!chmod($path, $dirmode)) {
            $dirmode_str=decoct($dirmode);
            print "Failed applying filemode '$dirmode_str' on directory '$path'\n";
            print "  `-> the directory '$path' will be skipped from recursive chmod\n";
            return;
        }
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if($file != '.' && $file != '..') {  // skip self and parent pointing directories
                $fullpath = $path.'/'.$file;
                chmod_R($fullpath, $filemode,$dirmode);
            }
        }
        closedir($dh);
    } else {
        if (is_link($path)) {
            print "link '$path' is skipped\n";
            return;
        }
        if (!chmod($path, $filemode)) {
            $filemode_str=decoct($filemode);
            print "Failed applying filemode '$filemode_str' on file '$path'\n";
            return;
        }
    }
}


function mysql_fetch_rowsarr($result, $numass=MYSQLI_BOTH) {
    return mysqli_fetch_rowsarr($result, $numass);
}

function mysqli_fetch_rowsarr($result, $numass=MYSQLI_BOTH) {
    $i=0;
    $keys=array_keys(mysqli_fetch_array($result, $numass));
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_array($result, $numass)) {
        foreach ($keys as $speckey) {
            $got[$i][$speckey]=$row[$speckey];
        }
        $i++;
    }
    return $got;
}
function GenerateSafeFileName($filename) {
    $filename = strtolower($filename);
    $filename = str_replace("#","_",$filename);
    $filename = str_replace(" ","_",$filename);
    $filename = str_replace("'","",$filename);
    $filename = str_replace('"',"",$filename);
    $filename = str_replace("__","_",$filename);
    $filename = str_replace('&',"and",$filename);
    $filename = str_replace('/','_',$filename);
    $filename = str_replace('\\','_',$filename);
    $filename = str_replace('?','',$filename);
    return $filename;
}

function ParseCICookie($cookieStr) {
    //$cookieStr='a:13:{s:10:"session_id";s:32:"4a7599fe3dbb7598e04dc26f60bfffb4";s:10:"ip_address";s:9:"127.0.0.1";s:10:"user_agent";s:81:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0";s:13:"last_activity";i:1353436633;s:10:"first_name";s:2:"LW";s:9:"last_name";s:4:"TEST";s:9:"post_name";s:22:"FORT LEONARD WOOD - LW";s:9:"post_code";s:2:"LW";s:7:"post_id";s:1:"3";s:7:"is_user";b:1;s:5:"email";s:6:"lwtest";s:9:"logged_in";b:1;s:8:"is_admin";b:0;}8d7d730604864a5f6f8f4630a071dca7';
    $ret = array();
    $meatOfCookieStr=substr($cookieStr, strpos($cookieStr, '{')+1, strrpos($cookieStr, '}')-(strpos($cookieStr, '{')+1));
    $meatOfCookieStrArr=explode(';', $meatOfCookieStr);
    $isCookieName=true;
    $cookieName="";
    $cookieValue="";
    $cookieLength=0;
    $datatype="s";
    for ($i=0;$i<count($meatOfCookieStrArr); $i++) {
        $cookieItem = $meatOfCookieStrArr[$i];
        if (strlen($cookieItem)>0) {
            $cookieItemArr = explode(':', $cookieItem);
            $cookieMeat=((isset($cookieItemArr[2])) ? $cookieItemArr[2] : join(":", $cookieItemArr) );
            if (startsWith($cookieMeat, '\"')) {
                $cookieMeat=substr($cookieMeat, 2);
            }
            if (startsWith($cookieMeat, '"')) {
                $cookieMeat=substr($cookieMeat, 1);
            }
            if (endsWith($cookieMeat, '\"')) {
                $cookieMeat=substr($cookieMeat, 0, strlen($cookieMeat)-2);
            }
            if (endsWith($cookieMeat, '"')) {
                $cookieMeat=substr($cookieMeat, 0, strlen($cookieMeat)-1);
            }
            if ($isCookieName) {
                $cookieLength=0;
                $cookieName=$cookieMeat;
                $cookieValue="";
                $isCookieName=false;
                //peek ahead to see if we should get the length from the next entry
                if (isset($meatOfCookieStrArr[$i+1])) {
                    $cookieItemNextArr = explode(':', $meatOfCookieStrArr[$i+1]);
                    $datatype=$cookieItemNextArr[0];
                    $cookieLength=($datatype=="s" ? $cookieItemNextArr[1] : strlen($cookieItemNextArr[1]) );
                }
            } else {
                $cookieValue.=(strlen($cookieValue)>0 ? ';' : '').$cookieMeat;
                if (strlen($cookieValue)>=$cookieLength) {
                    if ($datatype=="b") {
                        $ret[$cookieName] = (endsWith($cookieValue, '1') ? true: false);
                    } else if ($datatype=="i") {
                        $cookieItemArr = explode(":", $cookieValue);
                        $ret[$cookieName] = $cookieItemArr[1];
                    } else {
                        $ret[$cookieName] = $cookieValue;
                    }
                    $isCookieName=true;
                }
            }
        }
    }
    return $ret;
}
