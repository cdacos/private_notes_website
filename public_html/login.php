<?php
  session_start();
  if(isset($_SESSION['login'])) {
    header('LOCATION:notes.php');
    die();
  }
?>
<?php include 'html_header.php'; ?>
  <div class="container">
    <h3 class="text-center">Login</h3>
    <?php
      if(isset($_POST['submit'])){
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
        <input type="password" class="form-control" id="pwd" name="password" required>
      </div>
      <button type="submit" name="submit" class="btn btn-default">Login</button>
    </form>
  </div>
<?php include 'html_footer.php'; ?>

