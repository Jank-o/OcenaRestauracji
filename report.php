<?php
  require 'database.php';

  session_start();

  $sql = "SELECT * FROM comments WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);

  $comment = $result->fetch_assoc();

  if (!$comment) {
    header('Location: index.php');
    exit();
  }

  $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $guest_id = $user_ip ? sha1($user_ip) : null;

  $sql = "SELECT * FROM reports WHERE comment_id = " . $mysqli->real_escape_string($_GET['id']) . " AND guest_id = '" . $mysqli->real_escape_string($guest_id) . "'";
  $result = $mysqli->query($sql);

  $report = $result->fetch_assoc();

  if ($report) {
    header('Location: place.php?id=' . $comment['restaurant_id'] . '&reported=false');
  } else {
    $sql = "INSERT INTO reports (comment_id, guest_id) VALUES (" . $mysqli->real_escape_string($_GET['id']) . ", '" . $mysqli->real_escape_string($guest_id) . "')";
    $mysqli->query($sql);
  
    header('Location: place.php?id=' . $comment['restaurant_id'] . '&reported=true');
  }

  exit();
?>