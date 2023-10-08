<?php
  // カート内の削除する商品番号を受け取る
  $ident = $_POST['ident'];

  // Cartオブジェクトを生成し、商品削除メソッドを呼び出す
  require_once __DIR__ . '/../classes/cart.php';
  $cart = new Cart();
  $cart->deleteItem($ident);

  // cart_list.phpを読み込み、カート内の商品を画面に表示する
  require_once __DIR__ . '/cart_list.php';
