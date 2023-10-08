<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Cart extends DbData
{
  // 商品をカートに入れる ・・ テーブルcartに登録する
  public function addItem($ident, $quantity)
  {
    // すでにカート内にその商品がはいっているかどうかをチェックする
    $sql = "select * from cart where ident = ?";
    $stmt = $this->query($sql, [$ident]);
    $cart_item = $stmt->fetch();
    if ($cart_item) {
      // カート内にすでに入っているので、今回の注文数を追加する
      $new_quantity = $quantity + $cart_item['quantity'];
      if ($new_quantity > 10) $new_quantity = 10;
      $sql = "update cart set quantity = ? where ident = ?";
      $result = $this->exec($sql, [$new_quantity, $ident]);
    } else {
      // カート内にはまだ入っていないので登録する
      $sql = "insert into cart values(?, ?)";
      $result = $this->exec($sql, [$ident, $quantity]);
    }
  }

  // カート内のすべてのデータを取り出す
  public function getItems()
  {
    $sql = "select items.ident, items.name, items.maker, items.price, cart.quantity, items.image, items.genre from cart join items on cart.ident = items.ident";
    $stmt = $this->query($sql, []);
    $items = $stmt->fetchAll();
    return $items;
  }

  // カート内の商品を削除する
  public function deleteItem($ident)
  {
    $sql = "delete from cart where ident = ?";
    $result = $this->exec($sql, [$ident]);
  }

  // カート内の商品の個数を変更する
  public function changeQuantity($ident, $quantity)
  {
    $sql = "update cart set quantity = ? where ident = ?";
    $result = $this->exec($sql, [$quantity, $ident]);
  }

  // カート内のすべての商品を削除する
  public function clearCart()
  {
    $sql = "delete from cart";
    $result = $this->exec($sql, []);
  }
}
