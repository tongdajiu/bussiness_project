<?php
if (!defined('HN1'))
{
    die('Hacking attempt');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>检测环境</title>
<link href="../admin/css/StyleSheet.css" rel="stylesheet" />
<link href="../admin/css/list_style.css" rel="stylesheet" />
<style>
	body{margin:0;color:#666;font-size:14px;}
	.item{width:90%;margin:0 auto;}
	h3{font-size:20px;color:#333;padding:30px 0 10px;}
	.list{line-height:30px;}
	.list li{border-bottom:1px dashed #ddd;list-style:inside;padding:0 10px;}
	.list li:hover{background:#f1f1f1;}
	.list_right{float:right;}

	div.continue{width:90%;margin:0 auto;padding-top:40px;text-align:center;}
	div.continue .continue{border:1px solid #C4CCCC;border-right:1px solid #AEB7B4;padding:6px 12px;font-weight:bold;font-size:14px;color:#333;background:#F8EFAE;background:-webkit-gradient(linear,0 0,0 bottom,from(#F8EFAE),to(#F1D557));background:-moz-linear-gradient(#F8EFAE,#F1D557);background:linear-gradient(#F8EFAE,#F1D557);filter:progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#F8EFAE,endColorStr=#F1D557);-webkit-box-shadow:1px 1px 3px #6F7777;cursor:pointer}
</style>
</head>
<body id="checking">
	<div id="header"><a target="_blank"><h1>检测环境</h1></a></div>
	<form method="post">
		<div class="item">
			<h3>系统环境</h3>
			<ul class="list">
				<?php foreach($system_info as $info_item): ?>
					<li>
				        <span class="list_right"><?php echo $info_item[1];?></span>
				        <?php echo $info_item[0];?>
					</li>
		        <?php endforeach;?>
	        </ul>
	    </div>

	    <div class="item">
			<h3>目录权限检测</h3>
			<ul class="list">
				<?php foreach($dir_checking['detail'] as $checking_item): ?>
	          	<li>
					<span class="list_right">
			            <?php if ($checking_item[1] == '可写'):?>
			            <span style="color: green;"><?php echo $checking_item[1];?></span>
			            <?php else:?>
			            <span style="color: red;"><?php echo $checking_item[1];?></span>
			            <?php endif;?>
		            </span>

		          	<?php echo $checking_item[0];?>
	            </li>
	         	<?php endforeach;?>
	         </ul>
		</div>
		<div class="continue">
			<input type="button" class="continue" onclick="location.href='index.php'" value="重新检测" />
	      	<?php if($tag){ ?>
	      	<input type="button" class="continue" onclick="location.href='setting.php'" value="下一步:配置系统" />
			<?php } ?>	
		</div>
	</form>
</body>
</html>