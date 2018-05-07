<?php
  require 'common.php';
?>
<?php include 'html_header.php'; ?>
<?php
  $jump_to = '';
  if (array_key_exists('jump', $_GET)) {
    $jump_to = $_GET['jump'];
    if (is_numeric($jump_to)) {
      $jump = (int)$jump_to;
      $ago = new DateInterval('P'.abs($jump).'D'); // P1D means a period of 1 day
      $ago->invert = $jump < 0 ? 1 : 0;
      $date = new DateTime();
      $date->add($ago);
      $jump_to = $date->format('Y/m/d').'.md';
    }
  }
?>
<form action='' method='get'>
  <input type='text' name='jump' />
  <button type='submit'>Jump</button>
</form>
<ul>
<?php
  $lst = getDirContents(getNotesDir());
  rsort($lst);
  foreach ($lst as $file) {
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    echo "<li class='f_$ext'><a href='edit.php?path=$file'>$file</a></li>\n";
  }
?>
</ul>
<?php
  if (strlen($jump_to) > 0) { ?>
<script>
  parent.click('edit.php?path=<?php echo $jump_to; ?>');
</script>
<?php
  }
?>
<?php include 'html_footer.php'; ?>
