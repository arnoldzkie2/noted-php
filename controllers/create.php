<?php 
session_start();
if(!isset($_SESSION['user'])){
  header('Location: ../auth/login.php');
  exit();
}
$user = $_SESSION['user'];
$id = $user['id'];
include '../db/connect.php';
if(isset($_POST['create'])){
    $title = $_POST['title'] ?? null;
    $note_text = $_POST['note'] ?? null;
    if(empty($title) || empty($note_text)){
        echo '<script>alert("fillup all the forms!")</script>';
    } else {
        $query = "SELECT notes FROM notes WHERE id='$id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $notes_array = json_decode($row['notes'], true);
        $new_note = array('id' => uniqid(), 'title' => $title, 'text' => $note_text);
        if($notes_array == null){
            $notes_array = array();
        }
        array_push($notes_array, $new_note);
        $notes_json = json_encode($notes_array);
        $sql = "update notes set notes='$notes_json' where id='$id'";
        $result = mysqli_query($con, $sql);
        if($result){
            header('location: ../index.php');
            exit();
        } else {
            echo 'Server error';
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
    <title>Document</title>
</head>
<body>
    <form method='post'>
        <h1>Create new note</h1>
        <label >title</label>
        <input type="text" name='title'>
        <label >note</label>
        <input type="text" name='note'>
        <button name='create'>Create new note</button>
    </form>

    <a href="../index.php">back</a>
</body>
</html>