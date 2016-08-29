<?php
	header("Content-type:text/html;charset=utf-8");
	include "config.php";
	//post接收数据,只是演示效果,这里就省去验证了
	$name = $_POST['name'];
	$content = $_POST['content'];

	$sql = "insert into message (name,content) values ('{$name}','{$content}');";
	$res = mysql_query($sql,$link);
	if($res){
		echo '{"name": "'.$name.'","content": "'.$content.'","status": "1"}';
	}
?>
