<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Docker Workshop</title>
</head>
<body>

  <h1>Hello World, have a great <?= date("l") ?>!</h1>

  <?php
    if (getenv("MYSQL_HOST") == "") {
      die("Please provide the MYSQL_HOST environment variable, so I know where I have to connect to.");
    }

    $mysqli = new mysqli(getenv("MYSQL_HOST"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"), getenv("MYSQL_DATABASE"));
    if ($mysqli->connect_errno) {
      die("Database connection failed: " . $mysqli->connect_error);
    }
  ?>

  <p>Connection to mysql established.</p>

  <?php
    $statement = $mysqli->prepare("SELECT VERSION() as version;");
    $statement->execute();
    $result = $statement->get_result();

    $row = $result->fetch_assoc();
  ?>

  <p>MySQL version: <?= $row["version"] ?></p>

  <h2>Environment variables:</h2>
  <pre><?php print_r($_ENV); ?></pre>
  <p>Served by POD: <?php print(getenv('HOSTNAME')) ?></p>
  <p>Request URL <?php print($_SERVER['REQUEST_URI']) ?></p>
  <?php if ($_SERVER['REQUEST_URI'] == '/hash'):
    $result = "";

    for ($x = 0; $x <= 10; $x++) {
      $result .= password_hash('workshop', PASSWORD_BCRYPT, [ 'cost' => 15 ]) + '</br>';
    }
  ?><p><?php echo $result ?></p>
  <?php endif; ?>
</body>
</html>
