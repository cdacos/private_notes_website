<?php
  require 'common.php';

  $path = getFilePath($_GET['path']);
  $mimeType = getMimeType($path);
  header("Content-Type: $mimeType");
  if (substr($mimeType, 0, 4) === 'text') {
    echo getFileString($path);
  }
  else {
    readfile($path);
  }
  exit();
?>