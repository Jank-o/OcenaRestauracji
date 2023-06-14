<?php
  require '../database.php';

  session_start();

  $sql = "SELECT * FROM comments WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);

  $comment = $result->fetch_assoc();

  if (!$comment) {
    header('Location: comments.php');
    exit();
  }
  
  if ($_SESSION['user']['is_admin'] == 0) {
    header('Location: ../index.php');
    exit();
  }

  $sql = "UPDATE comments SET is_approved = 1 WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $mysqli->query($sql);

  header('Location: comments.php');

  exit();
?>