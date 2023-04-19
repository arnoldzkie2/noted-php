<?php 
session_start();
include '../db/connect.php';
$err = '';
if(isset($_POST['login'])){
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $checkEmail = "Select * from users where email='$email'";
  $emailResult = mysqli_query($con, $checkEmail);
  if(mysqli_num_rows($emailResult) == 0){
    $err = 'Email does not exist!';
  }else{
    $checkPass = "select * from users where email='$email' and password='$pass'";
    $passResult = mysqli_query($con, $checkPass);
    if(mysqli_num_rows($passResult) == 0){
      $err = 'Incorect Password!';
    } else {
      $query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
      $result = mysqli_query($con, $query);
      $user = mysqli_fetch_assoc($result);
      $_SESSION['user'] = $user;
      header('location: ../index.php');
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTED</title>
</head>
<body>
<div class="container">
  <h1>Log in</h1>
  <?php if(!empty($err)): ?>
    <div id='err'><?php echo $err; ?></div>
  <?php endif; ?>
  <form method='post'>
    <label for="">Email</label>
    <div>
      <input type="email" name='email' required>
    </div>  
    <label for="">Password</label>
    <div>
      <input type="password" name='pass' required>
    </div>  
    <br>
    <button name='login'>Log in</button>
  </form>
  <Br>
  <div>Don't have account yet? <a href="./register.php">Register</a></div>
</div>
</body>
</html>