<?php
  require '../database.php';

  session_start();

  $sql = "SELECT * FROM comments WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);

  $comment = $result->fetch_assoc();

  if (!$comment) {
    header('Location: reports.php');
    exit();
  }
  
  if ($_SESSION['user']['is_admin'] == 0) {
    header('Location: ../index.php');
    exit();
  }

  $sql = "DELETE FROM comments WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $mysqli->query($sql);

  header('Location: comments.php');

  exit();
?>