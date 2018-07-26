<?php
  require 'functions.php';

  checkActiveLogin();

  // server should keep session data for AT LEAST 8 hours
  ini_set('session.gc_maxlifetime', 28800);
  // each client should remember their session id for EXACTLY 8 hours
  session_set_cookie_params(28800);

  session_start();
  if(!isset($_SESSION['login'])) {
    header('LOCATION:start.php');
    die();
  }

  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
  header("Pragma: no-cache"); // HTTP 1.0.
  header("Expires: 0"); // Proxies.
?>

