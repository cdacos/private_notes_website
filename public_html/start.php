<?php
  require 'functions.php';

  if(isset($_COOKIE['token'])) {
    header('LOCATION:notes.php');
    die();
  }
?>
<?php include 'html_header.php'; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .container {
      width: 50%;
      margin: 0 auto;
    }
    .container form div {
      margin-bottom: 20px;
    }
  </style>
  <div class="container">
    <h3 class="text-center">Login</h3>
    <?php
      if(isset($_POST['password'])){
        $password = $_POST['password'];
        $config = parse_ini_file(__DIR__ . '/../config.ini', true);
        $hash = $config['notes']['password_hash'];
        if(password_verify($password, $hash)){
          doLogin();
          header('LOCATION:notes.php');
          die();
        } 
        else {
          echo "<div class='alert alert-danger'>Password is incorrect.</div>";
        }
      }
    ?>
    <form action="" method="post">
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
<div class="container">
  <h3>Last login</h3>
  <?php echo substr(getFileString(getFilePath('/last_login')), 40); ?>
</div>
<script>
  if (top.location != location) {
    top.location.href = document.location.href ;
  }
</script>
<?php include 'html_footer.php'; ?>

