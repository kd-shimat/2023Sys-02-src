<?php
// 送られてきた商品番号を受け取る														
$ident = $_GET['ident'];
// product.phpを読み込み、Productオブジェクトを生成する														
require_once __DIR__ . '/../classes/product.php';  // DIRの前後は2本のアンダースコア	
$product = new Product();
// 選択された商品を取り出す														
$item = $product->getItem($ident);

require_once  __DIR__  .  '/../header.php';	// header.phpを読み込む
?>

<form method="POST" action="../cart/cart_add.php"> <!-- カートに商品を入れる処理を行うPHP -->
	<input type="hidden" name="ident" value="<?= $item['ident'] ?>"> <!-- 商品番号を送るため -->
	<table>
		<tr>
			<th>商品名</th>
			<td><?= $item['name'] ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="td_center">
					<img class="detail_img" src="../images/<?= $item['image'] ?>">
				</div>
			</td>
		</tr>
		<tr>
			<th>メーカー・著者<br>アーティスト</th>
			<td><?= $item['maker'] ?></td>
		</tr>
		<tr>
			<th>価 格</th>
			<td>&yen;<?= number_format($item['price']) ?></td>
		</tr>
		<tr>
			<th>注文数</th>
			<td><select name="quantity">
					<?php
					for ($i = 1; $i <= 10; $i++) {
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
					?>
				</select></td>
		</tr>
		<tr>
			<th colspan="2"><input type="submit" value="カートに入れる"></th>
		</tr>
	</table>
</form>
<a href="product_select.php?genre=<?= $item['genre'] ?>">ジャンル別商品一覧に戻る</a>
<?php
require_once  __DIR__ . '/../footer.php';  // footer.phpを読み込む	
?>