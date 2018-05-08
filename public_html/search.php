<?php
  require 'common.php';

  $find = '';
  $results = array();

  if (array_key_exists('find', $_GET)) {
    $find = $_GET['find'];
    if (strlen($find) > 0) {
        exec("rg -n -i -e '$find' ../notes", $results);
    }
  }
?>
<?php include 'html_header.php'; ?>
<style>
  body {
    padding: 5px;
  }
</style>
    <form action="" method="get">
      <input type="text" name="find" style="width: 10em" value="<?php echo $find; ?>" />
      <button type="submit">Search</button>
    </form>
    <ul style="list-style-type: none; padding: 0; padding-left: 5px">
      <?php
        foreach ($results as $result) {
            $details = explode(":", $result);
            $path = getRelativePath(getFilePath(substr($details[0], 9)));
            $text = htmlspecialchars(trim($details[2]));
            echo "<li>• <a href='edit.php?path=$path&line=$details[1]'>".$text."</a></li>\n"; 
        }
      ?>
    </ul>
    <style>
      body { background-color: #F8F8F8; }
    </style>
<?php include 'html_footer.php'; ?>
