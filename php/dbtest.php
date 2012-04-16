<!doctype html>
<html>
  <head>
    <title>DB:Tests Web Display</title>
    <style>
      body { font-family: sans; }
      table {
        border-collapse: collapse;
        width: 90%;
        margin: auto;
      }
      table, th, td { border: 1px solid #444; }
      th {
        background: #666;
        color: #fff;
      }
      th, td { padding: 5px; }
      th:first-of-type, td:first-of-type {
        min-width: 175px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <?php
      require_once(dirname(__FILE__).'/DBManager.php');
      require_once(dirname(__FILE__).'/db_login.php');
      require_once(dirname(__FILE__).'/TestDisplayer.php');

      $dsn = "mysql:host={$db_host};dbname={$db_database}";
      $db_manager = new DBManager($dsn, $db_username, $db_password);
      $db_manager->open();
      $tests = $db_manager->getDBTests();
      echo TestDisplayer::createTable($tests);
    ?>
  </body>
</html>
