<?php
    // 送られてきた商品番号と数量を受け取る
    $ident = $_POST['ident'];
    $quantity = $_POST['quantity'];

    // Cartオブジェクトを生成し、カートに入れるメソッドを呼び出す
    require_once  __DIR__  .  '/../classes/cart.php';
    $cart = new Cart( );
    $cart->addItem($ident, $quantity);

    // cart_list.phpを読み込み、カート内の商品を画面に表示する
    require_once __DIR__ . '/cart_list.php';
