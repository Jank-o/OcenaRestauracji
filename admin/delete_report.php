<?php
  require '../database.php';

  session_start();

  $sql = "SELECT * FROM reports WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);

  $report = $result->fetch_assoc();

  if (!$report) {
    header('Location: reports.php');
    exit();
  }
  
  if ($_SESSION['user']['is_admin'] == 0) {
    header('Location: ../index.php');
    exit();
  }

  $sql = "DELETE FROM reports WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $mysqli->query($sql);

  header('Location: reports.php');

  exit();
?>