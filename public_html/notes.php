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

  function tabClick(i) {
    var p = document.querySelector('.fixed-column');
    var tabs = p.querySelectorAll('.tabs span');
    var panes = p.querySelectorAll('.pane');
    for (var j=0; j<2; j++) {
      tabs[j].classList.remove('chosen');
      panes[j].classList.remove('chosen')
    }
    tabs[i].classList.add('chosen');
    panes[i].classList.add('chosen');
    console.log(tabs);
    console.log(panes);
  }
</script>
<style>
.flex-container {
   display: flex;
   height: 100%;
}
.flex-column {
   flex: 1;
}
.fixed-column {
  width: 250px;
  background-color: #EEEEEE;
}
.tabs {
  width: 100%;
}
.tabs span {
  display: inline-block;
  padding: 2px 5px;
  border: 1px solid #000000;
  width: 113px;
  background-color: #333333;
  color: #FFFFFF;
}
.tabs span.chosen {
  border-bottom: 1px solid #EEEEEE;
  background-color: #EEEEEE;
  color: #000000;
}
.pane {
  display: none;
}
.pane.chosen {
  display: block;
  height: 100%;
}
</style>
<div class="flex-container">
  <div class="fixed-column">
    <div class="tabs"><span class="chosen" onclick="tabClick(0)">Files</span><span onclick="tabClick(1)">Search</span></div>
    <div class="pane chosen">
      <iframe id='list' src='list.php' style='height: 100%; width: 100%' frameBorder='0'></iframe>
    </div>
    <div class="pane">
      <iframe id='search' src='search.php' style='height: 100%; width: 100%' frameBorder='0'></iframe>
    </div>
  </div>
  <div class="flex-column">
    <iframe id='main' style='height: 100%; width: 100%' frameBorder='0'></iframe>
  </div>
</div>
<style>
  body { 
    overflow: hidden;
    padding-bottom: 50px;
  }
</style>
<?php include 'html_footer.php'; ?>
