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
  
  $sql = "SELECT *, (votes/rating) as score FROM restaurants ORDER BY created_at DESC";
  $result = $mysqli->query($sql);
  $restaurants = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina - Lokale - Oceny restauracji</title>
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
        <a href="restaurants.php" class="block border-2 border-gray-900 text-white bg-gray-900 rounded-md py-2 w-full text-center">Lokale</a>
        <a href="comments.php" class="block border-2 border-gray-900 rounded-md py-2 w-full text-center">Komentarze</a>
      </div>
      <div class="mt-6">
        <div class="text-xl italic font-bold mb-2">Lokale (<?php echo sizeof($restaurants ?? []) ?>)</div>
        <div>
          <?php
            if ($restaurants) {
              ?>
              <div class="space-y-2">
              <?php
                foreach ($restaurants as $restaurant) {
                  $rating = number_format($restaurant['rating'], 2, ',', '') ?? 0;
                  $votes = $restaurant['votes'] ?? 0;
                  ?>
                  <div class="bg-gray-200 dark:bg-gray-900 rounded p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                      <div class="flex flex-row items-center space-x-4">
                        <img src="<?php echo $restaurant['logo_url'] ?? 'https://via.placeholder.com/128x128?text=Logo'; ?>" alt="Logo" class="max-w-sm h-16 w-auto rounded">
                        <div>
                          <h3 class="text-xl font-bold"><?php echo $restaurant['name']; ?></h3>
                          <p class="text-gray-600 dark:text-gray-400"><?php echo $restaurant['location']; ?></p>
                        </div>
                      </div>
                      <div class="mt-1 md:mt-0 md:flex md:flex-col md:justify-end md:items-end">
                        <a href="edit_restaurant.php?id=<?php echo $restaurant['id']; ?>">Edytuj</a>
                      </div>
                    </div>
                    <?php
                    if ($restaurant['is_approved'] == 0) {
                      ?>
                      <div class="text-sm text-red-500 mt-2">
                        Restauracja oczekuje na zatwierdzenie.
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                  <?php
                }
              ?>
              </div>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php $mysqli->close(); ?>