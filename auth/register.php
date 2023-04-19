<?php 
include '../db/connect.php';
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $cpass = $_POST['cpass'];
    if(empty($name) || empty($email) || empty($password) || empty($cpass)){
        $err = 'Fill up all the forms!';
    } else if ($password !== $cpass || $cpass !== $password){
        $err = 'Password does not match!';
    } else {
        $emailExist = "select * from users where email='$email'";
        $emailResult = mysqli_query($con, $emailExist);
        if(mysqli_num_rows($emailResult) > 0){
            $err = 'Email already exists!';
        } else {
            $sql = "insert into users (name, email, password) values ('$name','$email','$password')";
            $result = mysqli_query($con, $sql);
            if($result){
                $user_id = mysqli_insert_id($con);
                $notes = array();
                $notes_json = json_encode($notes);
                $insert_notes = "insert into notes (id, notes) values ('$user_id','$notes_json')";
                $notes_result = mysqli_query($con, $insert_notes);
                if($notes_result){
                  header('location: ./login.php');
                  exit();
                }
            } else {
                $err = 'Registration failed!';
            }
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
  <h1>Sign up</h1>
  <?php if(!empty($err)): ?>
    <div id='err'><?php echo $err; ?></div>
  <?php endif; ?>
  <form method='post'>
    <Br>
    <label for="">Name</label>
    <div>
      <input type="text" name='name' required>
    </div>  
    <label for="">Email</label>
    <div>
      <input type="email" name='email' required>
    </div>  
    <label for="">Password</label>
    <div>
      <input type="password" name='pass' required>
    </div>  
    <label for="">Confirm password</label>
    <div>
      <input type="password" name='cpass' required>
    </div>  
    <br>
    <button name='register'>Sign up</button>
  </form>
  <Br>
  <div>Already signed up? <a href="./login.php">Login</a></div>
</div>
</body>
</html>
