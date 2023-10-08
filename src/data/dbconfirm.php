<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>dbselect.php</title>
</head>

<body>
  <h4>ショッピングサイトデータ確認：0J0X0XX 神戸電子</h4>
  <hr>
  <?php
  $dsn = 'mysql:host=localhost;dbname=shop;charset=utf8';
  $user = 'shopping';
  $password = 'site';

  try {
    $pdo = new PDO($dsn, $user, $password);
    $sql = 'select  *  from  items';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results  as  $result) {
      echo 'ident=' . $result['ident'] . ', name=' . $result['name'] . '<br>';
    }
    echo "<hr>";
    $sql = 'select  *  from  users';
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch();
    echo 'userId=' . $result['userId'] . ', name=' . $result['userName'] . '<br>';
  } catch (Exception $e) {
    echo 'Error:' . $e->getMessage();
    die();
  }
  $pdo = null;
  ?>
</body>

</html>