<?php
	//数据库配置信息(用户名,密码，数据库名，表前缀等)
	$cfg_dbhost = "localhost";
	$cfg_dbuser =	"root";
	$cfg_dbpwd = "1991lxy";
	$cfg_dbname = "test";
	$cfg_dbprefix = "";

	$link = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	mysql_select_db($cfg_dbname);
	mysql_query("set names utf8");
?>
