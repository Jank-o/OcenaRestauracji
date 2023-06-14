<?php
  require 'database.php';

  session_start();

  $login = $_POST['login'] ?? null;
  $password = $_POST['password'] ?? null;

  if ($login && $password) {
    $sql = "SELECT * FROM users WHERE name = '" . $mysqli->real_escape_string($login) . "' AND password = '" . sha1($mysqli->real_escape_string($password)) . "'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION['user'] = $row;
      header('Location: index.php');
    } else {
      ?>
      <div>
        <div class="flex bg-red-400 bg-opacity-30 p-4 text-sm text-black dark:text-white" role="alert">
          <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
          <div>Podane dane nie są poprawne!</div>
        </div>
      </div>
      <?php
    }
  }
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold mb-1">Zaloguj się</h1>
        <div class="space-x-4">
          <a href="index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Strona Główna</a>
          <a href="register.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Zarejestruj się</a>
        </div>
      </div>
      <div>
        <form class="flex flex-col space-y-2" action="login.php" method="post">
          <input type="text" name="login" required autocomplete="off" placeholder="Nazwa użytkownika" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          <input type="password" name="password" required autocomplete="off" placeholder="Hasło" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          <button type="submit" class="w-28 h-10 bg-black text-white uppercase font-bold px-4 rounded-md">Zaloguj</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

<?php $mysqli->close(); ?>