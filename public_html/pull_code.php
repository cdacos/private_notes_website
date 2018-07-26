<?php
  require 'common.php';
?>
<?php include 'html_header.php'; ?>
<?php
  shell_exec("cd ".getCodeDir()." && git pull");
?>
Done
<?php include 'html_footer.php'; ?>
