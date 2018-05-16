<!DOCTYPE html>
<html>
  <head>
    <style>
      /* ubuntu-mono-regular - latin */
      @font-face {
        font-family: 'Ubuntu Mono';
        font-style: normal;
        font-weight: 400;
        src: local('Ubuntu Mono'), local('UbuntuMono-Regular'),
            url('fonts/ubuntu-mono-v7-latin-regular.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
            url('fonts/ubuntu-mono-v7-latin-regular.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
      }
      /* source-sans-pro-regular - latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 400;
        src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'),
            url('fonts/source-sans-pro-v11-latin-regular.woff2') format('woff2'), /* Chrome 26+, Opera 23+, Firefox 39+ */
            url('fonts/source-sans-pro-v11-latin-regular.woff') format('woff'); /* Chrome 6+, Firefox 3.6+, IE 9+, Safari 5.1+ */
      }
      html, body {
        height: 100%;
        padding: 0;
        margin: 0;
      }
      body {
        font-family: 'Source Sans Pro', sans-serif;
      }
      textarea, .mono {
        font-family: 'Ubuntu Mono', monospace;
      }
      .footer {
        font-size: 75%;
      }
      textarea {
        width: 100%;
        height: 100%;
      }
      .menu {
        position: fixed;
        top: 0;
        right: 10px;
        padding: 5px;
      }
      .f_png, .f_jpg { display: none; }
      ul.listing {
        list-style-type: none; 
        padding: 0;
        padding-bottom: 50px;
      }
      ul.listing li {
        padding: 5px;
        background-color: #EEEEEE;
        cursor: pointer;
        color: #000000;
        font-weight: normal;
        font-size: 0.8em;
      }
      ul.listing li:hover {
        background-color: #CCCCCC;
      }
      ul.listing li.selected {  
        background-color: #333333;
        color: #FFFFFF;
      }
      form#frm {
        height: 100%;
        margin-bottom: -40px;
      }
      form.action {
        display:flex; 
        flex-direction: row; 
        /* justify-content: center; 
        align-items: center */
      }
      .icon {
        background: none;
        border: none;
        font-size: 1.2em;
        padding: 2px;
        margin: 0 5px;
      }
      .icon:hover {
        background-color: #FFFFFF;
      }
    </style>
    <script>
      function interceptAllLinks() {
        anchors = document.querySelectorAll('a');
        for (var i=0; i<anchors.length; i++) {
          anchors[i].onclick = function(o) {
            return parent.click(o.target.href);
          }
        }
      }

      function click(link) {
        location.href = link;
        return true;
      }

      function listingClick(href) {
        var listing = document.getElementsByClassName('listing')[0];
        var lis = listing.getElementsByTagName('li');

        for (var i=0; i<lis.length; i++) {
          var li = lis[i];
          li.classList.toggle('selected', href === li.dataset.href);
        }

        parent.click(href)
      }
    </script>
  </head>
  <body>
