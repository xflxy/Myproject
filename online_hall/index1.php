<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>php make page list</title>
<style type="text/CSS">
<!--
.page a:link {
color: #0000FF;
text-decoration: none;
}
.page a:visited {
text-decoration: none;
color: #0000FF;
}
.page a:hover {
text-decoration: none;
color: #0000FF;
}
.page a:active {
text-decoration: none;
color: #0000FF;
}
.page{color:#0000FF;}
-->
</style>
</head>
<body>
<table width="530" height="103" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<th width="30" height="38" bgcolor="#E3E3E3" scope="col">ID</th>
<th width="500" bgcolor="#E3E3E3" scope="col">���±���</th>
</tr>
<?php
/*
* Created on 2010-4-17
*
* Order by Kove Wong
*/
$link=MySQL_connect('localhost','root','1991lxy');
mysql_select_db('test');
mysql_query('set names gbk');

$Page_size=10;

$result=mysql_query('select * from message');
$count = mysql_num_rows($result);
$page_count = ceil($count/$Page_size);

$init=1;
$page_len=7;
$max_p=$page_count;
$pages=$page_count;

//�жϵ�ǰҳ��
if(empty($_GET['page'])||$_GET['page']<0){
$page=1;
}else {
$page=$_GET['page'];
}

$offset=$Page_size*($page-1);
$sql="select * from message limit $offset,$Page_size";
$result=mysql_query($sql,$link);
while ($row=mysql_fetch_array($result)) {
?>
<tr>
<td bgcolor="#E0EEE0" height="25px"><div align="center">
<?php echo $row['id']?>
</div></td>
<td bgcolor="#E0EEE"><div align="center">
<?php echo $row['name']?>
</div></td>
</tr>
<?php
}
$page_len = ($page_len%2)?$page_len:$pagelen+1;//ҳ�����
$pageoffset = ($page_len-1)/2;//ҳ���������ƫ����

$key='<div class="page">';
$key.="<span>$page/$pages</span> "; //�ڼ�ҳ,����ҳ
if($page!=1){
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">��һҳ</a> "; //��һҳ
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">��һҳ</a>"; //��һҳ
}else {
$key.="��һҳ ";//��һҳ
$key.="��һҳ"; //��һҳ
}
if($pages>$page_len){
//�����ǰҳС�ڵ�����ƫ��
if($page<=$pageoffset){
$init=1;
$max_p = $page_len;
}else{//�����ǰҳ������ƫ��
//�����ǰҳ����ƫ�Ƴ�������ҳ��
if($page+$pageoffset>=$pages+1){
$init = $pages-$page_len+1;
}else{
//����ƫ�ƶ�����ʱ�ļ���
$init = $page-$pageoffset;
$max_p = $page+$pageoffset;
}
}
}
for($i=$init;$i<=$max_p;$i++){
if($i==$page){
$key.=' <span>'.$i.'</span>';
} else {
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>";
}
}
if($page!=$pages){
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">��һҳ</a> ";//��һҳ
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">���һҳ</a>"; //���һҳ
}else {
$key.="��һҳ ";//��һҳ
$key.="���һҳ"; //���һҳ
}
$key.='</div>';
?>
<tr>
<td colspan="2" bgcolor="#E0EEE0"><div align="center"><?php echo $key?></div></td>
</tr>
</table>
</body>
</html> 