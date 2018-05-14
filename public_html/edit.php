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
?>
<form action="" method="post" id="frm">
  <input type="hidden" name="mtime" id="mtime" value="<?php echo $mtime; ?>" />
  <textarea name="contents" id="contents" onkeyup="contentsChanged()" onchange="contentsChanged()"><?php
    echo getFileString($path);
  ?></textarea>
  <div class="menu">
    <button type="submit">Sync</button>
  </div>
</form>
<span id="msg"></span>
<style>
  body { background-color: #FFFFEE; overflow: hidden; }
  textarea { background-color: #FFFFEE; border: 0; padding: 0; overflow-y: scroll; overflow-x: hidden; font-size: 1em; padding: 0 20px; }
  #msg { position: absolute; top: 50px; right: 0px; padding-right: 20px; color: #CCCCCC }
</style>
<script>
  var saveTimeoutId = 0;
  var mtime = document.getElementById('mtime');
  var contents = document.getElementById('contents');
  var original = contents.value;
  var msg = document.getElementById('msg');
  var countdown = 0;

  function contentsChanged() {
    if (contents.value != original) {
      window.clearTimeout(saveTimeoutId);
      countdown = 10;
      saveAsync();
    }
  }

  function saveAsync() {
    countdown--;
    if (contents.value == original || countdown > 0) {
      saveTimeoutId = window.setTimeout(saveAsync, 1000);
      msg.innerHTML = "Saving in... " + countdown;
      return;
    }
    var http = new XMLHttpRequest();
    var url = "save.php?path=<?php echo $_GET['path']; ?>";
    var params = "mtime=" + escape(mtime.value) + "&contents=" + escape(contents.value);

    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
          var r = http.responseText;
          console.log(r);
          if (r.startsWith("OK! ")) {
            mtime.value = r.substr(4);
            original = contents.value;
            msg.innerHTML = "Saved! ";
          }
          else {
            msg.innerHTML = r;
          }
        }
    }

    http.send(params);
  }

  var shortcutModifier = window.navigator.platform.startsWith("Mac") ? "Meta" : "Ctrl";
  function handleKeyShortcut(e) {
    var e = e || window.event; // for IE to cover IEs window event-object
    if ((shortcutModifier == "Meta" ? e.metaKey : e.ctrlKey) && e.key == 's') {
      console.log(e);
      document.getElementById('frm').submit();
      return false;
    }
  }
  document.onkeydown = handleKeyShortcut;

  window.addEventListener("beforeunload", function (e) {
    if (contents.value != original) {
      countdown = 0;
      saveAsync();
      var confirmationMessage = "\o/";
      e.returnValue = confirmationMessage;     // Gecko, Trident, Chrome 34+
      return confirmationMessage;              // Gecko, WebKit, Chrome <34
    }
    return "";
  });
</script>
<?php include 'html_footer.php'; ?>
