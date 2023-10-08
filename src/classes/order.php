<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Order extends DbData
{
  // カート内の全ての商品を注文内容として登録する
  public function addOrder($cartItems)
  {
    // 注文テーブルに登録
    $sql = "insert into orders(orderdate) values( ? )";
    $result = $this->exec($sql,  [date("Y-m-d H:i:s")]);
    // 注文番号を取得する
    $sql = "select  last_insert_id( )  from  orders";
    $stmt = $this->query($sql,  []);
    $result = $stmt->fetch();
    $orderId = $result[0];
    // 注文明細テーブルに登録する
    foreach ($cartItems  as  $item) {
      $sql = "insert into orderdetails values( ?, ?, ? )";
      $result = $this->exec($sql,  [$orderId,  $item['ident'],  $item['quantity']]);
    }
  }
}
