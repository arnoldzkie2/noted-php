<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}
$user = $_SESSION['user'];
$user_id = $user['id'];
include '../db/connect.php';
if(isset($_GET['id'])){
  $note_id = $_GET['id'];
  $query = "select * from notes where id='$user_id'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_array($result);
  $notes_json = $row['notes'];

  // decode the json file

  $notes_array = json_decode($notes_array, true);

  //find index to delete
  $index = -1;
  foreach($notes_array as $i => $note){
    if($note['id'] == $note_id){
      $index = $i;
      break;
    }
  }
  if($index >= 0){
    array_splice($notes_array, $index, 1);
  }
  // encode the json file
  $notes_json = json_encode($notes_array);

  //update the user notes

  $sql = "update notes set notes='$notes_json' where id='$user_id'";
  mysqli_query($con, $sql);
  header('location: ../index.php');
  exit();
}

?>