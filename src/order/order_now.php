<?php
// Cartオブジェクトを生成する
require_once __DIR__ . '/../classes/cart.php';
$cart = new Cart();

// カート内の全ての商品を取り出す
$cartItems = $cart->getItems();

// Orderオブジェクトを生成する
require_once __DIR__ . '/../classes/order.php';
$order = new Order();

// カート内の全ての商品を注文内容として登録する
// 注文テーブルordersと注文詳細テーブルorderdetailsに注文内容を登録する
$orderId = $order->addOrder($cartItems);

require_once  __DIR__  .  '/../header.php';  // header.phpを読み込む
?>

<p>お買い上げありがとうございました。<br>
  またのご利用をお待ちしております。</p>
<table>
  <tr>
    <th>&nbsp;</th>
    <th>商品名</th>
    <th>メーカー・著者<br>アーティスト</th>
    <th>価格</th>
    <th>注文数</th>
    <th>金額</th>
  </tr>
  <?php
  $total = 0;
  foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
  ?>
    <tr>
      <td class="td_mini_img"><img class="mini_img" src="../images/<?= $item['image'] ?>"></td>
      <td class="td_item_name"><?= $item['name'] ?></td>
      <td class="td_item_maker"><?= $item['maker'] ?></td>
      <td class="td_right">&yen;<?= number_format($item['price']) ?></td>
      <td class="td_right"><?= $item['quantity'] ?></td>
      <td class="td_right">&yen;<?= number_format($item['price'] * $item['quantity']) ?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <th colspan="5">合計金額</th>
    <td class="td_right">&yen;<?= number_format($total) ?></td>
  </tr>
</table>
<?php
// カート内の全ての商品を削除する
$cart->clearCart();
?>
<?php
require_once  __DIR__ . '/../footer.php';  // footer.phpを読み込む	
?>