<?php
  require 'database.php';

  session_start();

  $sort = isset($_GET['s']) && $_GET['s'] != '' ? $_GET['s'] : null;
  $query = isset($_GET['q']) && $_GET['q'] != '' ? $_GET['q'] : null;
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold mb-1">Oceny restauracji</h1>
        <?php
          if (isset($_SESSION['user'])) {
            ?>
              <div class="space-x-4">
                <a href="create.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Nowy lokal</a>
                <a href="user.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Panel użytkownika</a>
                <?php
                if ($_SESSION['user']['is_admin'] == 1) {
                  ?>
                  <a href="admin/index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Panel administratora</a>
                  <?php
                }
                ?>
                <a href="logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
              </div>
            <?php
          } else {
            ?>
              <div class="space-x-4">
                <a href="login.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Zaloguj się</a>
                <a href="register.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Zarejestruj się</a>
              </div>
            <?php
          }
          ?>
      </div>
      <div>
        <form class="flex flex-col md:flex-row md:flex-grow md:space-x-4 space-y-2 md:space-y-0" action="index.php" method="get">
          <input type="text" name="q" placeholder="Co chcesz ocenić?" value="<?php echo $query; ?>" class="w-full h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
          <div class="flex flex-row flex-grow space-x-2 md:space-x-4">
            <select name="s" class="w-full md:w-48 h-10 px-2 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900">
              <option value="">Nie sortuj</option>
              <option value="asc" <?php echo $sort == 'asc' ? 'selected' : ''; ?>>Oceny: Rosnąco</option>
              <option value="desc" <?php echo $sort == 'desc' ? 'selected' : ''; ?>>Oceny: Malejąco</option>
              <option value="only_5" <?php echo $sort == 'only_5' ? 'selected' : ''; ?>>Dobra piątka</option>
            </select>
            <button class="block h-10 bg-black text-white uppercase font-bold px-4 rounded-md">Szukaj</button>
          </div>
        </form>
      </div>
      <div class="space-y-2 mt-4">
        <?php
          $sql = "SELECT *, (votes/rating) as score FROM restaurants WHERE is_approved=1";

          if ($query) {
            $sql .= " and keywords LIKE '%" . $mysqli->real_escape_string($query) . "%'";
          }

          if ($sort && ($sort == 'asc' || $sort == 'desc')) {
            $sql .= " ORDER BY score " . $sort;
          } else if ($sort && $sort == 'only_5') {
            $sql .= " and rating > 4 ORDER BY RAND() LIMIT 5";
          } else {
            $sql .= " ORDER BY name ASC";
          }
          
          $result = $mysqli->query($sql);
        
          if ($result->num_rows > 0) {
            ?>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
              <h3 class="text-xl font-bold">
                Mamy dla Ciebie aż <?php echo $result->num_rows; ?>
                <?php echo $result->num_rows === 1 ? '<span>miejsce</span>' : ''; ?>
                <?php echo $result->num_rows >= 2 && $result->num_rows <= 4 ? '<span>miejsca</span>' : ''; ?>
                <?php echo $result->num_rows >= 5 || $result->num_rows === 0 ? '<span>miejsc</span>' : ''; ?>
              </h3>
              <?php
                if ($query) {
                  ?>
                    <div>
                      <a href="index.php" class="text-gray-500 dark:text-gray-300">Pokaż wszystkie</a>
                    </div>
                  <?php
                }
              ?>
            </div>
            <?php
            while($row = $result->fetch_assoc()) {
              $rating = number_format($row['rating'], 2, ',', '') ?? 0;
              $votes = $row['votes'] ?? 0;
              ?>
              <a href="place.php?id=<?php echo $row['id']; ?>" class="block transition-transform hover:scale-105">
                <div class="bg-gray-200 dark:bg-gray-900 rounded p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                  <div class="flex flex-row items-center space-x-4">
                    <img src="<?php echo $row['logo_url'] ?? 'https://via.placeholder.com/128x128?text=Logo'; ?>" alt="Logo" class="h-16 w-auto rounded">
                    <div>
                      <h3 class="text-xl font-bold"><?php echo $row['name']; ?></h3>
                      <p class="text-gray-600 dark:text-gray-400"><?php echo $row['location']; ?></p>
                    </div>
                  </div>
                  <div class="mt-1 md:mt-0 md:flex md:flex-col md:justify-end md:items-end">
                    <div class="text-lg font-medium flex flex-row items-center space-x-1 <?php echo $rating < 3 ? 'text-red-500' : 'text-green-600'; ?>">
                      <div><?php echo $rating; ?></div>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="#cba82a" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><path d="M239.2,97.4A16.4,16.4,0,0,0,224.6,86l-59.4-4.1-22-55.5A16.4,16.4,0,0,0,128,16h0a16.4,16.4,0,0,0-15.2,10.4L90.4,82.2,31.4,86A16.5,16.5,0,0,0,16.8,97.4,16.8,16.8,0,0,0,22,115.5l45.4,38.4L53.9,207a18.5,18.5,0,0,0,7,19.6,18,18,0,0,0,20.1.6l46.9-29.7h.2l50.5,31.9a16.1,16.1,0,0,0,8.7,2.6,16.5,16.5,0,0,0,15.8-20.8l-14.3-58.1L234,115.5A16.8,16.8,0,0,0,239.2,97.4Z"></path></svg>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">(<?php echo $votes; ?> ocen)</div>
                  </div>
                </div>
              </a>
              <?php
            }

            if ($result->num_rows > 10) {
              ?>
                <a href="index.php" class="text-gray-700">Pokaż wszystkie</a>
              <?php
            }
          } else {
            ?>
            <div class="text-center pt-4 md:pt-0">
              <div class="text-gray-800 dark:text-gray-200 text-xl font-bold">Brak szukanych lokali</div>
              <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Nie znaleźliśmy dla Ciebie interesujących miejsc :(</div>
              <div class="flex flex-row items-center justify-center mt-6 space-x-4">
                <a href="create.php" class="block flex items-center justify-center h-8 bg-black text-sm text-white uppercase font-bold px-4 rounded-md">Dodaj lokal</a>
                <?php
                  if ($query) {
                    ?>
                      <div>
                        <a href="index.php" class="text-gray-700 dark:text-gray-300">Pokaż wszystkie</a>
                      </div>
                    <?php
                  }
                ?>
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