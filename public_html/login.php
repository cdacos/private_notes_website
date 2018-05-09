<?php
  session_start();
  if(isset($_SESSION['login'])) {
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
          $_SESSION['login'] = true;
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
<?php include 'html_footer.php'; ?>

