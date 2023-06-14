<?php
  require '../database.php';

  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
  }

  if ($_SESSION['user']['is_admin'] == 0) {
    header('Location: ../index.php');
    exit();
  }
  
  $sql = "SELECT * FROM rating WHERE user_id=" . $mysqli->real_escape_string($_SESSION['user']['id']) . " ORDER BY created_at DESC";
  $result = $mysqli->query($sql);
  $votes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="flex justify-end space-x-4 mb-4">
        <a href="../index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Strona Główna</a>
        <a href="../logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
      </div>
      <div class="grid grid-cols-3 gap-4">
        <a href="reports.php" class="block border-2 border-gray-900 rounded-md py-2 w-full text-center">Zgłoszenia</a>
        <a href="restaurants.php" class="block border-2 border-gray-900 rounded-md py-2 w-full text-center">Lokale</a>
        <a href="comments.php" class="block border-2 border-gray-900 rounded-md py-2 w-full text-center">Komentarze</a>
      </div>
    </div>
  </div>
</body>
</html>

<?php $mysqli->close(); ?>