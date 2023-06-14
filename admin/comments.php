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
  
  $sql = "SELECT * FROM comments WHERE is_approved=0 ORDER BY created_at DESC";
  $result = $mysqli->query($sql);
  $comments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl-pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina - Komentarze - Oceny restauracji</title>
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
        <a href="comments.php" class="block border-2 border-gray-900 text-white bg-gray-900 rounded-md py-2 w-full text-center">Komentarze</a>
      </div>
      <div class="mt-6">
        <div class="text-xl italic font-bold mb-2">Komentarze do zaakceptowania</div>
        <div>
          <?php
            if ($comments) {
              ?>
              <div class="space-y-2">
              <?php
                foreach ($comments as $comment) {
                  $sql = "SELECT * FROM restaurants WHERE id=" . $mysqli->real_escape_string($comment['restaurant_id']);
                  $result = $mysqli->query($sql);
                  $restaurant = $result->fetch_assoc();
                  ?>
                  <div class="bg-gray-50 dark:bg-gray-900 rounded-md p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center justify-between">
                      <div class="text-base">W: <?php echo $restaurant['name']; ?></div>
                      <div class="flex flex-row items-center space-x-1">
                        <div class="text-gray-500 dark:text-gray-400">#<?php echo $comment['id']; ?></div>
                        <div>•</div>
                        <div><?php echo date('H:i, d.m.Y', strtotime($comment['created_at'])); ?></div>
                      </div>
                    </div>
                    <div class="mt-2"><?php echo nl2br($comment['message']); ?></div>
                    <div class="flex flex-row items-center mt-4 -mb-2 space-x-4">
                      <a href="accept_comment.php?id=<?php echo $comment['id']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="currentColor" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><polyline points="216 72 104 184 48 128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg>
                        Zaakceptuj
                      </a>
                      <a href="delete_comment_not_approved.php?id=<?php echo $comment['id']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="currentColor" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="216" y1="56" x2="40" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="104" y1="104" x2="104" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="152" y1="104" x2="152" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><path d="M200,56V208a8,8,0,0,1-8,8H64a8,8,0,0,1-8-8V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><path d="M168,56V40a16,16,0,0,0-16-16H104A16,16,0,0,0,88,40V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
                        Usuń komentarz
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
</body>
</html>

<?php $mysqli->close(); ?>