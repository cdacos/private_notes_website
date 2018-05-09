<?php
  require 'common.php';

  $path = $_GET['path'];
  $mimeType = getMimeType($path);
  $path = getFilePath($path);
  if (substr($mimeType, 0, 4) !== 'text') {
    header('LOCATION:file.php?path='.$_GET['path']);
    die();
  }

  $mtime = filemtime($path);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_mtime = (int)$_POST['mtime'];
    if (file_exists($path) && $mtime !== $old_mtime) {
      echo "FAIL! The file has changed. Save aborted. Cut and paste then revert.";
    }
    else if (array_key_exists('contents', $_POST)) {
      $dir = dirname($path);
      if (!file_exists($dir)) {
        mkdir($dir, 0, true);
      }
      file_put_contents($path, $_POST['contents']);
      clearstatcache();
      echo "OK! ".filemtime($path);
    }
  }
?>
