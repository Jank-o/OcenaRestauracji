<?php
  require 'config.php';

  try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $mysqli->set_charset('utf8');
  } catch (Exception $e) {
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
        <body class="h-full w-full bg-gray-200">
          <div class="flex items-start justify-center md:mt-10">
            <div class="mx-auto max-w-2xl w-full bg-white rounded-md shadow-lg p-8">
              <h1 class="text-center text-red-500 text-2xl font-bold">Nie udało się połączyć do bazy danych!</h1>
              <div class="text-center text-gray-700 mt-4"><?php echo $e->getMessage(); ?></div>
            </div>
          </div>
        </body>
      </html>
    <?php
    exit;
  }