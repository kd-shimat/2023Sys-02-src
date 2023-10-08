<?php
// genreの値を受け取る										
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	// POSTで送られてきた場合	
	$genre = $_POST['genre'];
} else {
	// GETで送られてきた場合	
	$genre = $_GET['genre'];
}

// Productオブジェクトを生成する										
require_once __DIR__ . '/../classes/product.php';
$product = new Product();

// 選択されたジャンルのデータを抽出										
$items = $product->getItems($genre);  // 抽出された商品データの結果セットを受け取る

require_once  __DIR__  .  '/../header.php';	// header.phpを読み込む
?>

<table>
	<tr>
		<th>&nbsp;</th>
		<th>商品名</th>
		<th>メーカー・著者<br>アーティスト</th>
		<th>価格</th>
		<th>詳細</th>
	</tr>
	<?php
	foreach ($items  as  $item) {
	?>
		<tr>
			<td class="td_mini_img"><img class="mini_img" src="../images/<?= $item['image'] ?>"></td>
			<td class="td_item_name"><?= $item['name'] ?></td>
			<td class="td_item_maker"><?= $item['maker'] ?></td>
			<td class="td_right">&yen;<?= number_format($item['price']) ?></td>
			<td><a href="product_detail.php?ident=<?= $item['ident'] ?>">詳細</a></td>
		</tr>
	<?php
	}
	?>
</table>

<?php
require_once  __DIR__ . '/../footer.php';  // footer.phpを読み込む	
?>