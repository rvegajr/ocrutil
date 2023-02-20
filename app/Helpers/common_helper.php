<?php

date_default_timezone_set('America/Chicago');
//set_include_path(ROOT_PATH.'inc'.PATH_SEPARATOR.ROOT_PATH.'inc/data'.PATH_SEPARATOR.get_include_path());
$conf = array();
$page = array();
$CurrentUser='sys';
define('BASEPATH',APPPATH);
define('ROOT_PATH',APPPATH);
$GLOBALS['LOGFILENAME']=realpath(APPPATH.'..').'/writable/logs/abct.log';
