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
    background-color: #F0F0F0;
    padding-bottom: 5em;
  }
</style>
    <form action="" method="get" class="action">
      <input type="text" name="find" style="width: 10em; font-size: 0.8em" value="<?php echo $find; ?>" />
      <button type="submit" class="icon">🔎</button>
      <a class="icon" href="search.php?find=%5C-+%5C%5B+%5C%5D">☑️</a>
    </form>
    <ul class="listing">
      <?php
        foreach ($results as $result) {
            $details = explode(":", $result, 3);
            $path = getRelativePath(getFilePath(substr($details[0], 9)));
            $text = htmlspecialchars(trim($details[2]));
            echo "<li data-href='edit.php?path=$path&line=$details[1]' onclick='listingClick(this.dataset.href);'>".$text."</li>\n"; 
        }
      ?>
    </ul>    
<?php include 'html_footer.php'; ?>
