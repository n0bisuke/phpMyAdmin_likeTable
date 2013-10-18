<?php
 $db_user = ""; //MySQLのユーザ名
 $db_pass = ""; //MySQLのパスワード
 $db_name = ""; //データベース名	
 $mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
?>
 
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" media="screen,print" href="style.css" />
</head>
<body>
	
	<?php
		//フォームからの投稿をデータベースに保存
		if(!empty($_POST['comment'])){//コメントが入力されたら実行
			$mysqli->query("INSERT INTO `board` (`name`,`title`,`comment`) 
				VALUES ('".$_POST['name']."','".$_POST['title']."','".$_POST['comment']."')");
		}
	 
		//コメントを削除
		if(!empty($_POST['del'])){//削除ボタンが押されたら実行
			$mysqli->query("DELETE FROM `board` WHERE `id` = ".$_POST['del']);
		}

		//編集 jQuery.post()を使う
		if(!empty($_POST['edit_mes'])){
			$edit_mes = $_POST['edit_mes'];
			$edit_id = $_POST['edit_id'];
			$edit_col = $_POST['edit_col'];
			$mysqli->query("UPDATE `board` SET  `".$edit_col."` =  '".$edit_mes."' WHERE  `board`.`id` =".$edit_id.";");
			header("Location: " . $_SERVER['PHP_SELF']); //ページリロード
		}

		//usersテーブルとboardsテーブルの連結
		$sql = "SELECT * FROM  `board` ORDER BY  `board`.`id` DESC ";
	?>

	<!-- タイトル部分を表示する -->
	<table id="data-list">
		<tr>
			<th>id</th>
			<th>name</th>
			<th>title</th>
			<th>comment</th>
			<th>timestamp</th>
			<th><!-- 削除ボタン用 --></th>
		</tr>
	<!-- データベースの内容を表示する -->
	<?php foreach ($mysqli->query($sql) as $key => $value): ?>
		<form action="dbconnect.php" method="post">
			<tr>
			    <td class="edit-id"><?php echo $value['id']; ?></td>
			    <td class="edit" title="li"><?php echo $value['name']; ?></td>
			    <td class="edit" title="li"><?php echo $value['title']; ?></td>
			    <td class="edit" title="li"><?php echo $value['comment']; ?></td>
			    <td class="edit" title="li"><?php echo $value['timestamp']; ?></td>
			    <td>
			    	<input type="hidden" name="del" value=<?php echo $value['id']; ?>>
					<input type="submit" value="削除">
				</td>
			</tr>
		</form>
	<?php endforeach; ?>
	</table>
	<span id="submit"></span>
	
	<!-- 入力フォーム -->
	<form action="dbconnect.php" method="post">
		名前:
		<input type="text" name="name" value="のびすけ"><br />
		タイトル:
		<input type="text" name="title" value="テスト投稿"><br />
		本文:
		<input type="text" name="comment"><br />
		<input type="submit">
	</form>
	<script src="http://jsdo.it/lib/jquery-1.8.0/js"></script>
	<script src="index.js"></script>
</body>
</html>