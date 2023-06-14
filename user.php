<?php
  require 'database.php';

  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
  }

  $guest_id = sha1($_SERVER['REMOTE_ADDR']);

  $sql = "SELECT * FROM comments WHERE user_id=" . $mysqli->real_escape_string($_SESSION['user']['id']) . " ORDER BY comments.created_at DESC";
  $result = $mysqli->query($sql);
  $comments = $result->fetch_all(MYSQLI_ASSOC);
  
  $sql = "SELECT * FROM rating WHERE user_id=" . $mysqli->real_escape_string($_SESSION['user']['id']) . " OR guest_id = '" . $mysqli->real_escape_string($guest_id) . "' ORDER BY created_at DESC";
  $result = $mysqli->query($sql);
  $votes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil <?php echo $_SESSION['user']['name']; ?> - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="flex justify-end space-x-4 mb-4">
        <a href="index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Strona Główna</a>
        <a href="logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
      </div>
      <div class="space-y-6">
        <div>
          <div class="text-xl italic font-bold mb-2">Twoje oceny</div>
          <div>
            <?php
              if ($votes) {
                ?>
                <div class="space-y-2">
                <?php
                  foreach ($votes as $vote) {
                    $restaurant = null;
                    if ($vote['restaurant_id']) {
                      $sql = "SELECT * FROM restaurants WHERE id=" . $mysqli->real_escape_string($vote['restaurant_id']);
                      $result = $mysqli->query($sql);
                      $restaurant = $result->fetch_assoc();
                    }
                    ?>
                    <a href="place.php?id=<?php echo $restaurant['id']; ?>" class="block transition-transform hover:scale-105">
                      <div class="bg-gray-200 dark:bg-gray-900 rounded p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex flex-row items-center space-x-4">
                          <img src="<?php echo $restaurant['logo_url'] ?? 'https://via.placeholder.com/128x128?text=Logo'; ?>" alt="Logo" class="h-16 w-auto rounded">
                          <div>
                            <h3 class="text-xl font-bold"><?php echo $restaurant['name']; ?></h3>
                            <p class="text-gray-600 dark:text-gray-400"><?php echo $restaurant['location']; ?></p>
                          </div>
                        </div>
                        <div class="mt-1 md:mt-0 md:flex md:flex-col md:justify-end md:items-end">
                          <div class="text-lg font-medium flex flex-row items-center space-x-1 <?php echo $vote['rating'] < 3 ? 'text-red-500' : 'text-green-600'; ?>">
                            <div><?php echo $vote['rating']; ?></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="#cba82a" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><path d="M239.2,97.4A16.4,16.4,0,0,0,224.6,86l-59.4-4.1-22-55.5A16.4,16.4,0,0,0,128,16h0a16.4,16.4,0,0,0-15.2,10.4L90.4,82.2,31.4,86A16.5,16.5,0,0,0,16.8,97.4,16.8,16.8,0,0,0,22,115.5l45.4,38.4L53.9,207a18.5,18.5,0,0,0,7,19.6,18,18,0,0,0,20.1.6l46.9-29.7h.2l50.5,31.9a16.1,16.1,0,0,0,8.7,2.6,16.5,16.5,0,0,0,15.8-20.8l-14.3-58.1L234,115.5A16.8,16.8,0,0,0,239.2,97.4Z"></path></svg>
                          </div>
                        </div>
                      </div>
                    </a>
                    <?php
                  }
                ?>
                </div>
                <?php
              }
            ?>
          </div>
        </div>
        <div>
          <div class="text-xl italic font-bold mb-2">Twoje komentarze</div>
          <div>
            <?php
              if ($comments) {
                ?>
                <div class="space-y-2">
                <?php
                  foreach ($comments as $comment) {
                    $restaurant_name = null;
                    if ($comment['restaurant_id']) {
                      $sql = "SELECT name FROM restaurants WHERE id=" . $mysqli->real_escape_string($comment['restaurant_id']);
                      $result = $mysqli->query($sql);
                      $restaurant_name = $result->fetch_assoc()['name'];
                    }
                    ?>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-md p-4">
                      <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center justify-between">
                        <div class="text-base">W: <?php echo $restaurant_name; ?></div>
                        <div class="flex flex-row items-center space-x-1">
                          <div class="text-gray-500 dark:text-gray-400">#<?php echo $comment['id']; ?></div>
                          <div>•</div>
                          <div><?php echo date('H:i, d.m.Y', strtotime($comment['created_at'])); ?></div>
                        </div>
                      </div>
                      <div class="mt-2"><?php echo nl2br($comment['message']); ?></div>
                      <div class="flex flex-row items-center mt-4 -mb-2">
                        <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="h-6 w-6">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="216" y1="56" x2="40" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="104" y1="104" x2="104" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="152" y1="104" x2="152" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><path d="M200,56V208a8,8,0,0,1-8,8H64a8,8,0,0,1-8-8V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><path d="M168,56V40a16,16,0,0,0-16-16H104A16,16,0,0,0,88,40V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
                        </a>
                      </div>
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
  </div>
</body>
</html>

<?php $mysqli->close(); ?>