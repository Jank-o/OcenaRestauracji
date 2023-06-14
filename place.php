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

  $rating = number_format($place['rating'], 2, ',', '') ?? 0;
  $votes = $place['votes'] ?? 0;
  
  $sql = "SELECT * FROM comments WHERE restaurant_id = " . $mysqli->real_escape_string($place['id']) . " AND is_approved=1 ORDER BY comments.created_at DESC";
  $result = $mysqli->query($sql);
  $comments = $result->fetch_all(MYSQLI_ASSOC);

  $comment = $_POST['comment'] ?? null;
  if ($comment) {
    if (isset($_SESSION['user'])) {
      $sql = "INSERT INTO comments (restaurant_id, user_id, guest_id, message, is_approved) VALUES (" . $mysqli->real_escape_string($place['id']) . ", " . $mysqli->real_escape_string($_SESSION['user']['id']) . ", '" . sha1($_SERVER['REMOTE_ADDR']) . "', '" . $mysqli->real_escape_string($comment) . "', 1)";
      $mysqli->query($sql);
    } else {
      $sql = "INSERT INTO comments (restaurant_id, guest_id, message, is_approved) VALUES (" . $mysqli->real_escape_string($place['id']) . ", '" . sha1($_SERVER['REMOTE_ADDR']) . "', '" . $mysqli->real_escape_string($comment) . "', 0)";
      $mysqli->query($sql);
    }

    header('Location: place.php?id=' . $place['id']);
  }
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $place['name'] ?> - Oceny restauracji</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full w-full bg-gray-200 dark:bg-gray-900 dark:text-white">
  <div class="flex items-start justify-center md:mt-10">
    <div class="mx-auto max-w-2xl w-full dark:bg-gray-800 bg-white rounded-md shadow-lg p-8">
      <div class="flex justify-end space-x-4 mb-4">
        <a href="index.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Strona Główna</a>
        <?php
        if (isset($_SESSION['user'])) {
          ?>
          <a href="logout.php" class="hover:underline text-gray-700 dark:text-gray-200 text-sm">Wyloguj się</a>
          <?php
        }
        ?>
      </div>
      <div class="mb-6">
        <div class="flex flex-row items-center space-x-6">
          <img src="<?php echo $place['logo_url'] ?? 'https://via.placeholder.com/256x256?text=Logo'; ?>" alt="Logo" class="max-w-sm h-32 w-auto rounded">
          <div>
            <h3 class="text-3xl font-bold"><?php echo $place['name']; ?></h3>
            <p class="text-lg text-gray-600 dark:text-gray-400"><?php echo $place['location']; ?></p>
          </div>
        </div>
      </div>
      <div>
        <div class="mb-4">
          <div class="text-xl italic font-bold mb-2">Ocena</div>
          <div class="flex items-center justify-between">
            <div class="md:flex md:flex-col">
              <div class="text-lg font-medium flex flex-row items-center space-x-1 <?php echo $rating < 3 ? 'text-red-500' : 'text-green-600'; ?>">
                <div><?php echo $rating; ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="#cba82a" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><path d="M239.2,97.4A16.4,16.4,0,0,0,224.6,86l-59.4-4.1-22-55.5A16.4,16.4,0,0,0,128,16h0a16.4,16.4,0,0,0-15.2,10.4L90.4,82.2,31.4,86A16.5,16.5,0,0,0,16.8,97.4,16.8,16.8,0,0,0,22,115.5l45.4,38.4L53.9,207a18.5,18.5,0,0,0,7,19.6,18,18,0,0,0,20.1.6l46.9-29.7h.2l50.5,31.9a16.1,16.1,0,0,0,8.7,2.6,16.5,16.5,0,0,0,15.8-20.8l-14.3-58.1L234,115.5A16.8,16.8,0,0,0,239.2,97.4Z"></path></svg>
              </div>
              <div class="text-sm text-gray-600 dark:text-gray-400">(<?php echo $votes; ?> ocen)</div>
            </div>
            <div class="flex flex-row items-center space-x-1 md:space-x-2">
              <a href="rate.php?id=<?php echo $place['id']; ?>&rate=1" class="block flex items-center justify-center text-xl h-8 w-8 rounded-md hover:dark:bg-gray-900 hover:bg-gray-300 border dark:border-gray-900 border-gray-300">1</a>
              <a href="rate.php?id=<?php echo $place['id']; ?>&rate=2" class="block flex items-center justify-center text-xl h-8 w-8 rounded-md hover:dark:bg-gray-900 hover:bg-gray-300 border dark:border-gray-900 border-gray-300">2</a>
              <a href="rate.php?id=<?php echo $place['id']; ?>&rate=3" class="block flex items-center justify-center text-xl h-8 w-8 rounded-md hover:dark:bg-gray-900 hover:bg-gray-300 border dark:border-gray-900 border-gray-300">3</a>
              <a href="rate.php?id=<?php echo $place['id']; ?>&rate=4" class="block flex items-center justify-center text-xl h-8 w-8 rounded-md hover:dark:bg-gray-900 hover:bg-gray-300 border dark:border-gray-900 border-gray-300">4</a>
              <a href="rate.php?id=<?php echo $place['id']; ?>&rate=5" class="block flex items-center justify-center text-xl h-8 w-8 rounded-md hover:dark:bg-gray-900 hover:bg-gray-300 border dark:border-gray-900 border-gray-300">5</a>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="#cba82a" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><path d="M239.2,97.4A16.4,16.4,0,0,0,224.6,86l-59.4-4.1-22-55.5A16.4,16.4,0,0,0,128,16h0a16.4,16.4,0,0,0-15.2,10.4L90.4,82.2,31.4,86A16.5,16.5,0,0,0,16.8,97.4,16.8,16.8,0,0,0,22,115.5l45.4,38.4L53.9,207a18.5,18.5,0,0,0,7,19.6,18,18,0,0,0,20.1.6l46.9-29.7h.2l50.5,31.9a16.1,16.1,0,0,0,8.7,2.6,16.5,16.5,0,0,0,15.8-20.8l-14.3-58.1L234,115.5A16.8,16.8,0,0,0,239.2,97.4Z"></path></svg>
            </div>
          </div>
        </div>
        <div class="mb-4">
          <div class="text-xl italic font-bold">Komentarze (<?php echo sizeof($comments ?? []); ?>)</div>
          <form class="mt-2 mb-4" action="place.php?id=<?php echo $place['id']; ?>" method="post">
            <textarea name="comment" rows="2" cols="30" class="w-full py-2 px-3 rounded-md bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-300 dark:border-gray-900" placeholder="Napisz komentarz..."></textarea>
            <button type="submit" class="w-28 h-10 bg-black text-white uppercase font-bold px-4 rounded-md">Wyślij</button>
          </form>
          <?php
            if (isset($_GET['reported']) && $_GET['reported'] == 'true') {
              ?>
              <div class="my-6">
                <div class="flex bg-blue-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                  <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>Komentarz został zgłoszony. Dziękujemy!</div>
                </div>
              </div>
              <?php
            } else if (isset($_GET['reported']) && $_GET['reported'] == 'false') {
              ?>
              <div class="my-6">
                <div class="flex bg-red-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                  <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>Komentarz nie został zgłoszony. Możliwe, że już go zgłosiłeś/aś!</div>
                </div>
              </div>
              <?php
            }

            if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
              ?>
              <div class="my-6">
                <div class="flex bg-green-400 bg-opacity-30 rounded-lg p-4 text-sm text-black dark:text-white" role="alert">
                  <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                  <div>Komentarz został usunięty.</div>
                </div>
              </div>
              <?php
            }
            
            if ($comments) {
              ?>
              <div class="space-y-2">
                <?php
                  foreach ($comments as $comment) {
                    $username = null;
                    if ($comment['user_id']) {
                      $sql = "SELECT * FROM users WHERE id = " . $comment['user_id'];
                      $user = $mysqli->query($sql)->fetch_assoc();
                      $username = $user['name'];
                    }
                    ?>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-md p-4">
                      <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center justify-between">
                        <div class="text-base">Od: <?php echo $username ?? '<i>anonimowy</i>'; ?></div>
                        <div class="flex flex-row items-center space-x-1">
                          <div class="text-gray-500 dark:text-gray-400">#<?php echo $comment['id']; ?></div>
                          <div>•</div>
                          <div><?php echo date('H:i, d.m.Y', strtotime($comment['created_at'])); ?></div>
                        </div>
                      </div>
                      <div class="mt-2"><?php echo nl2br($comment['message']); ?></div>
                      <div class="flex flex-row items-center mt-4 -mb-2">
                        <a href="report.php?id=<?php echo $comment['id']; ?>" class="h-6 w-6">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="40" y1="216" x2="40" y2="48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><path d="M40,168c64-48,112,48,176,0V48C152,96,104,0,40,48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
                        </a>
                        <?php
                          if (sha1($_SERVER['REMOTE_ADDR']) == $comment['guest_id'] || (isset($_SESSION['user']) && $_SESSION['user']['id'] == $comment['user_id'])) {
                            ?>
                              <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="h-6 w-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="216" y1="56" x2="40" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="104" y1="104" x2="104" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="152" y1="104" x2="152" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><path d="M200,56V208a8,8,0,0,1-8,8H64a8,8,0,0,1-8-8V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><path d="M168,56V40a16,16,0,0,0-16-16H104A16,16,0,0,0,88,40V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
                              </a>
                            <?php
                          }
                        ?>
                      </div>
                    </div>
                    <?php
                  }
                ?>
              </div>
              <?php
            } else {
              ?>
              <div class="text-gray-700 dark:text-gray-300">Nie ma jeszcze komentarzy.</div>
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