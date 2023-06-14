<?php
  require 'database.php';

  session_start();

  $name = $_POST['name'] ?? null;
  $location = $_POST['location'] ?? null;
  $logo_url = $_POST['logo_url'] ?? null;
  $additional_keywords = $_POST['additional_keywords'] ?? null;
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nowy lokal - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold mb-1">Nowy lokal</h1>
        <div class="space-x-4">
          <a href="index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Strona Główna</a>
          <?php
          if (isset($_SESSION['user'])) {
            ?>
            <a href="logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
            <?php
          }
          ?>
        </div>
      </div>
      <div>
        <form class="flex flex-col space-y-4" action="create.php" method="post">
          <div>
            <label class="text-gray-600 dark:text-gray-200" for="name">Nazwa lokalu</label>
            <input type="text" name="name" id="name" autocomplete="off" placeholder="Nazwa lokalu" class="mt-1 w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          </div>
          <div>
            <label class="text-gray-600 dark:text-gray-200" for="location">Pełny adres lokalu</label>
            <input type="text" name="location" id="location" autocomplete="off" placeholder="Adres lokalu..." class="mt-1 w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          </div>
          <div>
            <label for="logo_url">Adres URL do logo lokalu</label>
            <div class="text-xs text-gray-600 dark:text-gray-400">Adres musi kończyć się na np. .png, .jpg, .jpeg, .gif.</div>
            <input type="text" name="logo_url" id="logo_url" autocomplete="off" placeholder="Adres URL..." class="mt-2 w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          </div>
          <div>
            <label class="text-gray-600 dark:text-gray-200" for="additional_keywords">Tagi lokalu</label>
            <div class="text-xs text-gray-600 dark:text-gray-400">Wypełnienie tego pomaga w szukaniu (np. kawiarnia, vege)</div>
            <input type="text" name="additional_keywords" id="additional_keywords" autocomplete="off" placeholder="Słowa kluczowe" class="mt-2 w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          </div>
          <button type="submit" class="w-28 h-10 bg-black text-white uppercase font-bold px-4 rounded-md">Stwórz</button>
        </form>
        <?php
          if ($name && $location) {
            $keywords = implode(', ', [$name, $location, $additional_keywords]);
            $is_approved = isset($_SESSION['user']) && $_SESSION['user']['is_admin'] ? 1 : 0;
            $sql = 'INSERT INTO restaurants (name, location, logo_url, keywords, is_approved) VALUES (\'' . $mysqli->real_escape_string($name) . '\', \'' . $mysqli->real_escape_string($location) . '\', \'' . $mysqli->real_escape_string($logo_url) . '\', \'' . $mysqli->real_escape_string($keywords) . '\', ' . $is_approved . ')';
            $query = $mysqli->query($sql);
            
            if ($query) {
              ?>
              <div class="mt-6">
                <div class="flex bg-green-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                  <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>Stworzono nowy lokal!</div>
                </div>
              </div>
              <?php
            } else {
              ?>
              <div class="mt-6">
                <div class="flex bg-red-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                  <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>Wystąpił błąd!</div>
                </div>
              </div>
              <?php
            }
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

<?php $mysqli->close(); ?>