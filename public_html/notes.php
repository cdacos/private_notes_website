<?php
  require 'common.php';
?>
<?php include 'html_header.php'; ?>
<script>
  function click(link) {
    console.log('Parent: ' + link);
    document.getElementById('main').src = link;
    return false;
  }
</script>
<table style='width: 100%; height: 100%'>   
  <tr>
    <td style='height: 100%; width: 200px'><iframe id='list' src='list.php' style='height: 100%; width: 200px' frameBorder='0'></iframe></td>
    <td style='height: 100%'><iframe id='main' style='height: 100%; width: 100%' frameBorder='0'></iframe></td>
    <td style='height: 100%; width: 250px'><iframe id='search' src='search.php' style='height: 100%; width: 250px;' frameBorder='0'></iframe></td>
  </tr>
</table>
ZZZZ
<style>
  body { overflow: hidden; }
</style>
<?php include 'html_footer.php'; ?>
