<?php
  unset($_COOKIE['token']);
  setcookie('token', '', time() - 3600, '/');
  header('LOCATION:start.php');
  die();
?>
