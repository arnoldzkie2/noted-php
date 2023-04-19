<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id'];

include '../db/connect.php';

if (isset($_GET['id'])) {
    $note_id = $_GET['id'];

    $query = "SELECT * FROM notes WHERE id='$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $notes_array = json_decode($row['notes'], true);

    // Find the note object with the specified id
    $note_index = array_search($note_id, array_column($notes_array, 'id'));
    $note = $notes_array[$note_index];
    $default_title = $note['title'];
    $default_text = $note['text'];
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $text = $_POST['note'];

    $query = "SELECT * FROM notes WHERE id='$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $notes_array = json_decode($row['notes'], true);

    $note_index = array_search($note_id, array_column($notes_array, 'id'));
    $notes_array[$note_index]['title'] = $title;
    $notes_array[$note_index]['text'] = $text;

    // Update the notes array in the database
    $notes_json = json_encode($notes_array);
    $query = "UPDATE notes SET notes='$notes_json' WHERE id='$user_id'";
    mysqli_query($con, $query);

    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update note</title>
</head>
<body>
    <form method="post">
        <h1>Update note</h1>
        <label>Title</label>
        <input type="text" name="title" value="<?php echo $default_title; ?>">
        <label>Note</label>
        <input type="text" name="note" value="<?php echo $default_text; ?>">
        <button name="update">Update</button>
    </form>
    <br>
    <a href="../index.php">Back</a>
</body>
</html>
