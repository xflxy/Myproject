<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="images/index.css" type="text/css" rel="stylesheet">
<title>网上灵堂</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#sub").click(function(){
		//只是说明原理,然后这里省去了验证文本框内容的步骤，直接发送ajax请求
		$.post("deal.php",{name : $("#name").val(), content : $("#content").val()}, function(data){
				if(data.status){
					var str = "<li><strong>"+data.name+"</strong> 发表了："+data.content+"</li>";
					$("#show").prepend(str);  //在前面追加
				}else{
					alert("评论失败");
				}
			}, 'json');	
	});				 
});
$(function(){
	$("p a").click(function(){
		var love = $(this);
		var id = love.attr("rel");
		love.fadeOut(300);
		$.ajax({
			type:"POST",
			url:"love.php",
			data:"id="+id,
			cache:false,
			success:function(data){
				love.html(data);
				love.fadeIn(300);
			}
		});
		return false;
	});
});
</script>
</head>

<body>
<div class="sitetop"></div>
<div class="sitemain">
  <div class="maintop">
  <p class="title">永远怀念某某某</p>
  <div class="pic"></div>
  </div>
  <div class="maincontent">
  <table class="tab" width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h3>生平简介</h3><p>XXX同志长期在党政机关工作，他忠诚于党的事业，拥护党的路线、方针、政策，时刻与党组织保持一致。他认真履行工作职责，无论在哪个部门和单位，都能够勤勤恳恳、兢兢业业、任劳任怨、默默奉献，丝毫不计较个人得失。他为人正直、真诚、宽厚，对自己严格要求，对同志团结共事，对事业高度负责，对家人呵护备至。因此，深受大家的爱戴和敬重。XXX同志廉洁自律，一生清白做人，他所表现的党员风范、敬业精神、道德风貌永远是我们做人的楷模、学习的榜样！</p><p>XXX同志的一生，是平凡的一生，又是奉献的一生、充实的一生。XXX同志的逝世，使我们失去了一位好同志。他虽离我们而去，但他那种勤政廉政和无私奉献精神，仍值得我们学习和汲取。我们要化悲痛为力量，以XXX同志为榜样，勤奋学习，努力工作，再创佳绩。以慰XXX同志在天之灵。</p></td>
  </tr>
  <tr>
    <td height="20px"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60%"><h3>纪念相册</h3></td>
    <td width="40%"><h3>生平文章</h3></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td height="20px"></td>
  </tr>
   <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60%"><h3>纪念留言</h3>  
   <div id="form">
	<form action="deal.php" name="myform" method="post" id="suggest_form">
		用户名：<input type="text" size="50px" name="name" id="name" /><br/>
		内&nbsp;&nbsp;容：<textarea name="content" rows="6" cols="80" id="content"></textarea>&nbsp;&nbsp;
		<input type="button" value="提交留言" id="sub"/>
	</form>
</div>
<ul id="show">
<?php
	include "config.php";
	$sql = "select * from message;";
    $Page_size=10;

    $result=mysql_query('select * from message');
    $count = mysql_num_rows($result);
    $page_count = ceil($count/$Page_size);

    $init=1;
    $page_len=7;
    $max_p=$page_count;
    $pages=$page_count;

    //判断当前页码
    if(empty($_GET['page'])||$_GET['page']<0){
    $page=1;
    }else {
    $page=$_GET['page'];
    }

    $offset=$Page_size*($page-1);
    $sql="select * from message limit $offset,$Page_size";
    $result=mysql_query($sql,$link);
	while($row=mysql_fetch_array($result)){
		echo "<li><strong>".$row['name']."</strong> 发表了：".$row['content']."</li>";
	}
	$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数
$pageoffset = ($page_len-1)/2;//页码个数左右偏移量

$key='<div class="page">';
$key.="<span>$page/$pages</span> "; //第几页,共几页
if($page!=1){
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">第一页</a> "; //第一页
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页</a>"; //上一页
}else {
$key.="第一页 ";//第一页
$key.="上一页"; //上一页
}
if($pages>$page_len){
//如果当前页小于等于左偏移
if($page<=$pageoffset){
$init=1;
$max_p = $page_len;
}else{//如果当前页大于左偏移
//如果当前页码右偏移超出最大分页数
if($page+$pageoffset>=$pages+1){
$init = $pages-$page_len+1;
}else{
//左右偏移都存在时的计算
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
$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">下一页</a> ";//下一页
$key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">最后一页</a>"; //最后一页
}else {
$key.="下一页 ";//下一页
$key.="最后一页"; //最后一页
}
$key.='</div>';
?>
<div align="center"><?php echo $key?></div>
</ul> 
    </td>
  </tr>
</table>
</td>
   </tr>
   <tr>
    <td height="20px"></td>
  </tr>
   <tr>
    <td width="60%"><h3>献花点烛</h3>
    <ul class="list">
     <?php
	 include_once("config.php");
	 $sql = mysql_query("select * from pic");
	 while($row=mysql_fetch_array($sql)){
		 $pic_id = $row['id'];
		 $pic_name = $row['pic_name'];
		 $pic_url = $row['pic_url'];
		 $love = $row['love'];
	 ?>
     	<!--<li><img src="images/<?php echo $pic_url;?>" alt="<?php echo $pic_name;?>"><p><a href="#" class="img_on" rel="<?php echo $pic_id;?>"><?php echo $love;?></a></p></li>-->
        <li><img src="images/<?php echo $pic_url;?>" alt="<?php echo $pic_name;?>"><p><a href="#" class="img_on" rel="<?php echo $pic_name;?>"><?php echo $love;?></a></p></li>
        <?php }?>
     </ul>
     <div class="clear"></div>
    </td>
  </tr>
</table>
  </div>
</div>
<div class="sitebottom"></div>
</body>
</html>
