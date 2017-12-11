<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
function formSubmit(form){
     var tempFun = form.onsubmit ;
     //这里用来阻止表单重复提交
     form.onsubmit = function(){return false;}
     //这个IF可以用来做验证，验证失验还原验证方法，
     if(false)    form.onsubmit=tempFun ;//验证方法还原
     return true ;
}
</script>
<title>配置</title>
<link href="../admin/css/StyleSheet.css" rel="stylesheet" />
<link href="../admin/css/list_style.css" rel="stylesheet" />
<style>
	body{margin:0;color:#666;font-size:14px;}
	.item{width:640px;margin:0 auto;}
	h3{font-size:20px;color:#333;padding:30px 0 10px;}
	table{width:100%;}
	table tr td{padding:5px 10px 5px 0;}
	table input{border:1px solid #ddd;height:26px;padding:0 5px;}
	div.continue{width:90%;margin:0 auto;padding-top:40px;text-align:center;}
	div.continue .continue{border:1px solid #C4CCCC;border-right:1px solid #AEB7B4;padding:6px 12px;font-weight:bold;font-size:14px;color:#333;background:#F8EFAE;background:-webkit-gradient(linear,0 0,0 bottom,from(#F8EFAE),to(#F1D557));background:-moz-linear-gradient(#F8EFAE,#F1D557);background:linear-gradient(#F8EFAE,#F1D557);filter:progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#F8EFAE,endColorStr=#F1D557);-webkit-box-shadow:1px 1px 3px #6F7777;cursor:pointer}
</style>
</head>
<body id="checking">
	<div id="header"><a target="_blank"><h1>配置系统</h1></a></div>
	<form name="myform" action="setting.php" method="post" enctype="multipart/form-data" onsubmit="return formSubmit(this);">

		<div class="item">
	  		<h3>数据库账号</h3>
			<table>
				<tr>
				    <td width="150" align="right">数据库主机:</td>
				    <td align="left"><input type="text" name="db_host"  value="localhost" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">端口号:</td>
				    <td align="left"><input type="text" name="db_port"  value="3306" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">用户名:</td>
				    <td align="left"><input type="text" name="db_user"  value="root" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">密码:</td>
				    <td align="left"><input type="password" name="db_pass"  value="" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">数据库名:</td>
				    <td align="left"><input type="text" name="db_name"  value="" />
				     请注意：数据库名不可重复！！！   
				   </td>
				</tr>
			</table>
		</div>
		<div class="item">
	  		<h3>管理员</h3>
			<table>
				<tr>
				    <td width="150" align="right">管理员账号:</td>
				    <td align="left"><input type="text" name="admin_name"  value="admin" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">登录密码:</td>
				    <td align="left"><input type="password" name="admin_pass"  value="" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">密码确认:</td>
				    <td align="left"><input type="password" name="admin_pwd"  value="" /></td>
				</tr>
			</table>
		</div>
		<div class="item">
	  		<h3>网站</h3>
			<table>
				<tr>
				    <td width="150" align="right">微信appid:</td>
				    <td align="left"><input type="text" name="appid"  value="" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">微信appsecret:</td>
				    <td align="left"><input type="text" name="appsecret"  value="" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">微信token:</td>
				    <td align="left"><input type="text" name="token"  value="" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">站点地址:</td>
				    <td align="left"><input type="text" name="site_url"  value="<?php echo $_SERVER["HTTP_HOST"]; ?>" /></td>
				</tr>
				<tr>
				    <td width="150" align="right">站点名称:</td>
				    <td align="left"><input type="text" name="site_name"  value="" /></td>
				</tr>
			</table>
		</div>

		<div class="continue">
			<input type="button" class="continue" value="上一步:检测环境" onclick="location.href='index.php'" />
			<input type="submit" class="continue" value="立即安装" onclick="this.disabled=true;this.value='安装中……';document.myform.submit();"/>
		</div>

	</form>
</body>
</html>