<?php
  require 'common.php';
?>
<?php include 'html_header.php'; ?>
<script>
  function click(link) {
    var q = parseQuery(link.substr(link.indexOf('?')));
    hash = '#' + q['path'];
    document.getElementById('main').src = link;
    if (history.pushState) {
      history.pushState(null, null, hash);
    }
    else {
      location.hash = hash;
    }
    return false;
  }

  function parseQuery(queryString) {
    var query = {};
    var pairs = (queryString[0] === '?' ? queryString.substr(1) : queryString).split('&');
    for (var i = 0; i < pairs.length; i++) {
        var pair = pairs[i].split('=');
        query[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || '');
    }
    return query;
  }

  function tabClick(i) {
    var p = document.querySelector('.fixed-column');
    var tabs = p.querySelectorAll('.tabs span');
    var panes = p.querySelectorAll('.pane');
    for (var j=0; j<tabs.length; j++) {
      tabs[j].classList.remove('chosen');
      panes[j].classList.remove('chosen')
    }
    tabs[i].classList.add('chosen');
    panes[i].classList.add('chosen');
    console.log(tabs);
    console.log(panes);
  }

  function showLoginIfExpired() {
    var http = new XMLHttpRequest();
    var url = "heartbeat.php";

    http.open("GET", url, true);

    http.onreadystatechange = function() {
      if(http.readyState == 4 && http.status == 200) {
        var r = http.responseText;
        console.log(r);
        if (r.startsWith("FAIL")) {
          location.href = 'start.php';
        }
      }
    }

    http.send();    
  }

  window.setInterval(showLoginIfExpired, 60000);
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
  width: 69px;
  background-color: #333333;
  color: #FFFFFF;
  font-size: 0.8em;
  cursor: pointer;
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
    <div class="tabs">
      <span class="chosen" onclick="tabClick(0)">Files</span>
      <span onclick="tabClick(1)">Search</span>
      <span onclick="tabClick(2)">Misc</span>
    </div>
    <div class="pane chosen">
      <iframe id='list' src='list.php?jump=0' style='height: 100%; width: 100%' frameBorder='0'></iframe>
    </div>
    <div class="pane">
      <iframe id='search' src='search.php' style='height: 100%; width: 100%' frameBorder='0'></iframe>
    </div>
    <div class="pane" style="padding: 10px">
      <a href="file.php?path=logs/access.log">access log</a><br />
      <a href="file.php?path=logs/error.log">error log</a><br />
      <a href="pull_code.php">pull code</a><br />
      <a href="logout.php">logout</a><br />
      <p><?php echo $_checked_login; ?></p>
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
