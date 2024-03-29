<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<?php require 'admin-menu.php'; ?>

<body>
	
<div class="th0">商品番号</div>
<div class="th1">商品名</div>
<div class="th1">価格</div><br>
<?php
include('../functions.php');
$pdo = connect_to_db();

if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'insert':
		if (empty($_REQUEST['name']) || 
			!preg_match('/^[0-9]+$/', $_REQUEST['price'])) break;
		$sql=$pdo->prepare('insert into product values(null,?,?)');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['price']]);
		break;
	case 'update':
		if (empty($_REQUEST['name']) || 
			!preg_match('/^[0-9]+$/', $_REQUEST['price'])) break;
		$sql=$pdo->prepare(
			'update product set name=?, price=? where id=?');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['price'], 
			$_REQUEST['id']]);
		break;
	case 'delete':
		$sql=$pdo->prepare('delete from product where id=?');
		$sql->execute([$_REQUEST['id']]);
		break;
	}
}
foreach ($pdo->query('select * from product') as $row) {
	echo '<form class="ib" action="edit3.php" method="post">';
	echo '<input type="hidden" name="command" value="update">';
	echo '<input type="hidden" name="id" value="', $row['id'], '">';
	echo '<div class="td0">';
	echo $row['id'];
	echo '</div> ';
	echo '<div class="td1">';
	echo '<input type="text" name="name" value="', $row['name'], '">';
	echo '</div> ';
	echo '<div class="td1">';
	echo '<input type="text" name="price" value="', $row['price'], '">';
	echo '</div> ';
	echo '<div class="td2">';
	echo '<input type="submit" value="更新">';
	echo '</div> ';
	echo '</form> ';
	echo '<form class="ib" action="edit3.php" method="post">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '<input type="hidden" name="id" value="', $row['id'], '">';
	echo '<input type="submit" value="削除">';
	echo '</form><br>';
	echo "\n";
}
?>
<form action="admin-edit.php" method="post">
<input type="hidden" name="command" value="insert">
<div class="td0"></div>
<div class="td1"><input type="text" name="name"></div>
<div class="td1"><input type="text" name="price"></div>
<div class="td2"><input type="submit" value="追加"></div>
</form>


</body>
</html>