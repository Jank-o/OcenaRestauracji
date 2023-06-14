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

  if ($comment['user_id'] == $user_id || $comment['guest_id'] == $guest_id) {
    $sql = "DELETE FROM comments WHERE id = " . $mysqli->real_escape_string($_GET['id']);
    $mysqli->query($sql);
  }

  header('Location: place.php?id=' . $comment['restaurant_id'] . '&deleted=true');

  exit();
?>