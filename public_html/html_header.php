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
      .mono {
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
        right: 0;
        background-color: #CCCCCC;
        padding: 5px;
      }
      .f_png, .f_jpg { display: none; }
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
        console.log('Child: ' + link);
        location.href = link;
        return true;
      }
    </script>
  </head>
  <body>
