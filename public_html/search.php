<?php
  require 'common.php';

  $find = '';
  $results = array();

  if (array_key_exists('find', $_GET)) {
    $find = $_GET['find'];
    if (strlen($find) > 0) {
        exec("rg -n -e '$find' ../notes", $results);
    }
  }
?>
<?php include 'html_header.php'; ?>
    <form action="" method="get">
      <input type="text" name="find" value="<?php echo $find; ?>" />
      <button type="submit">Search</button>
    </form>
    <table>
      <?php
        foreach ($results as $result) {
            $details = explode(":", $result);
            $path = getRelativePath(getFilePath($details[0]));
            echo "<tr><td><a href='file.php?path=$path&line=$details[1]'>".$path."</a></td><td class='mono'>".$details[2]."</td></tr>\n"; 
        }
      ?>
    </table>
    <div class="footer">
        <?php echo (new DateTime())->format(DateTime::ATOM); ?>
    </div>
<?php include 'html_footer.php'; ?>
