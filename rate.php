<?php
  require 'database.php';

  session_start();

  $sql = "SELECT * FROM restaurants WHERE id = " . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);

  $place = $result->fetch_assoc();

  if (!$place) {
    header('Location: index.php');
    exit();
  }

  $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $guest_id = $user_ip ? sha1($user_ip) : null;

  $sql = "SELECT * FROM rating WHERE restaurant_id = " . $mysqli->real_escape_string($place['id']) . " AND guest_id = '" . $mysqli->real_escape_string($guest_id) . "'";

  $result = $mysqli->query($sql);

  $rating = $result->fetch_assoc();

  $votes = $place['votes'];
  if ($rating) {
    if ($user_id) $sql = "UPDATE rating SET rating = " . $mysqli->real_escape_string($_GET['rate']) . ", user_id=" . $mysqli->real_escape_string($user_id) . " WHERE restaurant_id = " . $mysqli->real_escape_string($place['id']) . " AND guest_id = '" . $mysqli->real_escape_string($guest_id) . "'";
    else $sql = "UPDATE rating SET rating = " . $mysqli->real_escape_string($_GET['rate']) . " WHERE restaurant_id = " . $mysqli->real_escape_string($place['id']) . " AND guest_id = '" . $mysqli->real_escape_string($guest_id) . "'";

    $result = $mysqli->query($sql);
  } else {
    if ($user_id) $sql = "INSERT INTO rating (restaurant_id, user_id, guest_id, rating) VALUES ({$mysqli->real_escape_string($place['id'])}, {$mysqli->real_escape_string($user_id)}, '{$mysqli->real_escape_string($guest_id)}', {$mysqli->real_escape_string($_GET['rate'])})";
    else $sql = "INSERT INTO rating (restaurant_id, guest_id, rating) VALUES ({$mysqli->real_escape_string($place['id'])}, '{$mysqli->real_escape_string($guest_id)}', {$mysqli->real_escape_string($_GET['rate'])})";
    
    $result = $mysqli->query($sql);
    $votes = $votes + 1;
  }

  $sql = "SELECT AVG(rating) AS average FROM rating WHERE restaurant_id = " . $mysqli->real_escape_string($place['id']);
  $result = $mysqli->query($sql);
  $rating = $result->fetch_assoc();

  $sql = "UPDATE restaurants SET votes = " . $mysqli->real_escape_string($votes) . ", rating = " . $mysqli->real_escape_string($rating['average']) . " WHERE id = " . $mysqli->real_escape_string($place['id']);
  $result = $mysqli->query($sql);
  
  header('Location: place.php?id=' . $place['id']);
  exit();
?>