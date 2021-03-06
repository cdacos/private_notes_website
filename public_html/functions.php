<?php
$_checked_login = 'ZAZ';
$_last_login_file = '/var/tmp/private_notes_last_login';

function doLogin() {
    updateLogin(getGUID());
}

function updateLogin($guid) {
    $client = getClientDetails();
    $contents = $guid.' | '.getClientDetails();
    saveFile($GLOBALS['_last_login_file'], $contents);
    setcookie('token', $guid, ['expires' => time()+28800, 'samesite' => 'Strict']);
    return $guid;
}

function checkLogin() {
    $contents = getFileString($GLOBALS['_last_login_file']);
    $token = '';
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
    }
    $guid = substr($contents, 0, 38);
    if (strlen($guid) === 38 && $guid === $token) {
        updateLogin($guid);
        return substr($contents, 41);
    }
    unset($_COOKIE['token']);
    setcookie('token', '', time() - 3600, '/');
    return '';
}

function logoutIfInvalid() {
    $c = checkLogin();
    $GLOBALS['_checked_login'] = $c;
    if (strlen($c) == 0) {
        doLogout();
    }
}

function doLogout() {
    setcookie('token', '');
    header('LOCATION:start.php');
    die();
}

  function getNotesDir() {
    return '/notes/';
  }

  function getCodeDir() {
    return realpath(__DIR__.'/..').'/';
  }

  function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
      $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
      $relative = getRelativePath($path);
      if (substr($value, 0, 1) != ".") {
        if (is_dir($path)) {
          getDirContents($path, $results);
        }
        else {
          $results[] = $relative;
        }
      }
    }
    return $results;
  }

  function getFilePath($path) {
    if ($path === 'logs/access.log' || $path === 'logs/error.log') {
      return realpath('/var/'.$path);
    }
    if (substr($path, 0, 1) === '/' || strpos($path, '..') !== false) {
      return '';
    }
    return getNotesDir().$path;
  }

  function getRelativePath($path) {
    $base = getNotesDir();
    if (substr($path, 0, strlen($base)) == $base) {
      return substr($path, strlen(getNotesDir()));
    }
    return $path;
  }

  function getFileString($path) {
    $s = '';
    if (file_exists($path)) {
      $s = file_get_contents($path);
    }
    if (strlen($s) === 0) {
      return getFileHeader($path);
    }
    return $s;
  }

  function getMimeType($path) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext === 'md' || $ext === 'txt' || $ext === 'log') {
      return 'text/plain';
    }
    else if ($ext === 'htm' || $ext === 'html') {
        return 'text/html';
    }
    else if ($ext === 'jpg' || $ext === 'jpeg') {
      return 'image/jpeg';  
    }
    else if ($ext === 'png') {
      return 'image/png';
    }
    return 'application/octet-stream';
  }
  
  function getFileHeader($path) {
    try {
      // # Sunday, April 29, 2018
      $p = getRelativePath($path);
      $s = str_replace('/', '-', substr($p, 0, strlen($p)-3));
      $d = new DateTime($s);
    }
    catch (Exception $e) { 
      $d = new DateTime();
    }
    return $d->format('# l, F j, Y')."\n\n";
  }

  function saveFile($path, $text) {
    $dir = dirname($path);
    if (!file_exists($dir)) {
      $filemode = 0755;
      mkdir($dir, $filemode, true);
      // $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
      // foreach($iterator as $item) {
      //   chmod($item, $filemode);
      // }
    }
    file_put_contents($path, $text);
    clearstatcache();
  }

  function dirSort($a, $b) {
    // Dates are in reverse order, else alphabetic
    $a1 = substr($a, 0, 1);
    $b1 = substr($b, 0, 1);
    if (is_numeric($a1) && is_numeric($b1)) {
      return strcmp($b, $a);
    }
    else if (!is_numeric($a1) && is_numeric($b1)) {
      return -1;
    }
    else if (is_numeric($a1) && !is_numeric($b1)) {
      return 1;
    }
    else {
      return strcmp($a, $b);
    }
  }

  function getGUID() {
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }
    else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
  }

  function getClientDetails() {
    return $_SERVER['REMOTE_ADDR'] . " - " . $_SERVER['HTTP_USER_AGENT'] . " - " . date(DATE_ISO8601, $_SERVER['REQUEST_TIME']);
  }
?>
