<?php
  require 'common.php';

  $path = $_GET['path'];
  $mimeType = getMimeType($path);
  $path = getFilePath($path);
  if (substr($mimeType, 0, 4) !== 'text') {
    header('LOCATION:file.php?path='.$_GET['path']);
    die();
  }
?>
<?php include 'html_header.php'; ?>
<?php
  $mtime = filemtime($path);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_mtime = (int)$_POST['mtime'];
    if (file_exists($path) && $mtime !== $old_mtime) {
      echo "The file has changed. Save aborted. Cut and paste then revert.";
    }
    else if (array_key_exists('contents', $_POST)) {
      $dir = dirname($path);
      if (!file_exists($dir)) {
        mkdir($dir, 0, true);
      }
      file_put_contents($path, $_POST['contents']);
      shell_exec("cd ".getNotesDir()." && git add --all && git commit -m 'Saved' && git push");
      header('LOCATION:edit.php?path='.$_GET['path']);
      die();
    }
  }

  $now = new DateTime();
?>
<script>
function handleKeyShortcut(e) {
  var e = e || window.event; // for IE to cover IEs window event-object
  if (e.ctrlKey && e.key == 's') {
    console.log(e);
    document.getElementById('frm').submit();
    return false;
  }
}
document.onkeydown = handleKeyShortcut;
parent.document.onkeydown = handleKeyShortcut;
</script>
<form action="" method="post" id="frm" style="height: 100%">
  <input type="hidden" name="mtime" value="<?php echo $mtime; ?>" />
  <textarea name="contents"><?php
    echo getFileString($path);
  ?></textarea>
  <div class="menu">
    <a href="edit.php?path=<?php echo $_GET['path']; ?>"><?php echo $_GET['path']; ?></a>
    <button type="submit">Save</button>
  </div>
</form>
<style>
  body { background-color: #FFFFEE; overflow: hidden; }
  textarea { background-color: #FFFFEE; border: 0; padding: 5px; overflow-y: scroll; overflow-x: hidden; }
</style>
<?php include 'html_footer.php'; ?>
