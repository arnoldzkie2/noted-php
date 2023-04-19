<?php
session_start();
if(!isset($_SESSION['user'])){
  header('Location: ./auth/login.php');
  exit();
}
$user = $_SESSION['user'];
$user_id = $user['id'];
include './db/connect.php';
$query = "SELECT * FROM notes WHERE id='$user_id'";
$result = mysqli_query($con, $query);
echo "Welcome " . $user['name'] . "!<br><br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTED</title>
</head>
<body>
<div class="notes">
<?php 
while($row = mysqli_fetch_array($result)) {
    $notes = json_decode($row['notes'], true);
    if(!empty($notes)){
    foreach ($notes as $note) {
        echo "<div class='note'>";
        echo "<h3>title: " . $note['title'] . "</h3>";
        echo "<p>note: ". $note['text'] . "</p>";
        echo "<br>";
        echo "<a href='./controllers/delete.php?id=".$note['id']."'>delete</a>";
        echo "<br>";
        echo "<a href='./controllers/update.php?id=".$note['id']."'>update</a>";
        echo "</div>";
    }
} else {
       echo "<div class='note'>";
        echo "<h3> you have 0 notes</h3>";
        echo "<a href='./controllers/create.php'>Create now</a>";
        echo "</div>";
}
    }
?>
</div>
    <Br>
    <Br>
    <Br>
    <Br>
    <Br>
    <div>
        <a href="./controllers/create.php">Create</a>
        <Br>
        <a href="./auth/logout.php">logout</a>
    </div>
</body>
</html>