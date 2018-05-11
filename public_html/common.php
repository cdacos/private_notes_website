<?php
  session_start();
  if(!isset($_SESSION['login'])) {
    header('LOCATION:login.php');
    die();
  }

  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
  header("Pragma: no-cache"); // HTTP 1.0.
  header("Expires: 0"); // Proxies.

  function getNotesDir() {
    return realpath(__DIR__.'/../notes').'/';
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
    if ($ext === 'md' || $ext === 'txt') {
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
?>
