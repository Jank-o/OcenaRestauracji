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
  
  $sql = "SELECT * FROM restaurants WHERE id=" . $mysqli->real_escape_string($_GET['id']);
  $result = $mysqli->query($sql);
  $restaurant = $result->fetch_assoc();

  if (isset($_GET['mode']) && $_GET['mode'] == 'edit') {
    $sql = "UPDATE restaurants SET name='" . $mysqli->real_escape_string($_POST['name']) . "', is_approved=" . (isset($_POST['is_approved']) ? 1 : 0) . ", location='" . $mysqli->real_escape_string($_POST['location']) . "', logo_url='" . $mysqli->real_escape_string($_POST['logo_url']) . "', keywords='" . $mysqli->real_escape_string($_POST['keywords']) . "' WHERE id=" . $mysqli->real_escape_string($_GET['id']);
    $result = $mysqli->query($sql);
    header('Location: edit_restaurant.php?id=' . $_GET['id'] . '&success=true');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina - Lokal <?php echo $restaurant['name']; ?> - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="flex justify-end space-x-4 mb-4">
        <a href="restaurants.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Lokale</a>
        <a href="../logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
      </div>
      <div class="mt-6">
        <form action="edit_restaurant.php?id=<?php echo $restaurant['id']; ?>&mode=edit" method="post">
          <div class="mb-6">
            <div class="flex flex-row items-center space-x-6">
              <img src="<?php echo $restaurant['logo_url'] ?? 'https://via.placeholder.com/256x256?text=Logo'; ?>" alt="Logo" class="max-w-sm h-32 w-auto rounded">
              <div>
                <div class="space-y-2">
                  <input type="text" required name="name" value="<?php echo $restaurant['name']; ?>" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
                  <input type="text" required name="location" value="<?php echo $restaurant['location']; ?>" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
                  <input type="text" name="logo_url" value="<?php echo $restaurant['logo_url']; ?>" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
                </div>
              </div>
            </div>
          </div>
          <div>
            <textarea name="keywords" rows="4" cols="30" class="w-full py-2 px-3 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900"><?php echo $restaurant['keywords']; ?></textarea>
            <div class="my-4">
              <label for="is_approved">
                <input type="checkbox" name="is_approved" value="1" <?php if ($restaurant['is_approved'] == 1) { echo 'checked'; } ?> />
                Zatwierdź restaurację
              </label>
            </div>
            <div class="flex flex-row items-center space-x-2">
              <button type="submit" class="block w-28 h-10 bg-black text-white uppercase font-bold px-4 rounded-md">Zapisz</button>
              <a href="delete_restaurant.php?id=<?php echo $restaurant['id']; ?>" class="block w-28 h-10 bg-red-600 text-white uppercase font-bold px-4 rounded-md flex items-center justify-center text-center"><div>Usuń</div></a>
            </div>
          </div>
        </form>
        <?php
          if (isset($_GET['success']) && $_GET['success'] == 'true') {
            ?>
            <div class="mt-6">
              <div class="flex bg-green-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div>Pomyślnie zapisano zmiany!</div>
              </div>
            </div>
            <?php
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

<?php $mysqli->close(); ?>