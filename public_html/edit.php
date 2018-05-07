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
      header('LOCATION:edit.php?path='.$_GET['path']);
      die();
    }
  }

  $now = new DateTime();
?>
<form action="" method="post" style="height: 100%">
  <input type="hidden" name="mtime" value="<?php echo $mtime; ?>" />
  <textarea name="contents"><?php
    echo getFileString($path);
  ?></textarea>
  <div class="menu">
    <span class="path"><?php echo $_GET['path']; ?></span>
    <a href="edit.php?path=<?php echo $_GET['path']; ?>">Revert</a>
    <button type="submit" name="submit">Save</button>
  </div>
</form>
<?php echo $now->format(DateTime::ATOM); ?>
<?php include 'html_footer.php'; ?>
