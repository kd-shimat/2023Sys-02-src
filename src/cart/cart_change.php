<?php
  // 注文数を変更する商品番号と注文数を受け取る
  $ident = $_POST['ident'];
  $quantity = $_POST['quantity'];

  // Cartオブジェクトを生成し、注文数変更メソッドを呼び出す
  require_once __DIR__ . '/../classes/cart.php';
  $cart = new Cart();
  $cart->changeQuantity($ident, $quantity);

  // cart_list.phpを読み込み、カート内の商品を画面に表示する
  require_once __DIR__ . '/cart_list.php';
