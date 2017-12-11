<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once SCRIPT_ROOT . 'logic/agent_infoBean.php';
require_once SCRIPT_ROOT . 'logic/agent_infoBean.php';


$id 	= !isset($_GET['id']) ? 0 : intval($_GET['id']);
$userid = !isset($_GET['userid']) ? 0 : intval($_GET['userid']);
$ib 	= new agent_infoBean();
$obj 	= $ib->detail($db, $id);
$act 	= !isset($_REQUEST['act']) ? "list" : $_REQUEST['act'];

switch ($act)
{

	case 'edit' :
		edit($db);
	break;
}

function edit($db) {
	$ib = new agent_infoBean();
	$id = intval($_REQUEST['id']);
	if (empty ($id)) {
		redirect("?module=agent_info_set&id=" . $id, "ID不能为空");
		return;
	}
	$userid = $_REQUEST['userid'] == null ? '' : sqlUpdateFilter($_REQUEST['userid']);
	$type = $_REQUEST['type'] == null ? '' : sqlUpdateFilter($_REQUEST['type']);
	$name = $_REQUEST['name'] == null ? '' : sqlUpdateFilter($_REQUEST['name']);
	$mobile = $_REQUEST['mobile'] == null ? '' : sqlUpdateFilter($_REQUEST['mobile']);
	$email = $_REQUEST['email'] == null ? '' : sqlUpdateFilter($_REQUEST['email']);
	$id_number = $_REQUEST['id_number'] == null ? '' : sqlUpdateFilter($_REQUEST['id_number']);
	$pre_money = $_REQUEST['pre_money'] == null ? '' : sqlUpdateFilter($_REQUEST['pre_money']);
	$join_money = $_REQUEST['join_money'] == null ? '' : sqlUpdateFilter($_REQUEST['join_money']);
	$city = $_REQUEST['city'] == null ? '' : sqlUpdateFilter($_REQUEST['city']);
	$join_time = $_REQUEST['join_time'] == null ? '' : sqlUpdateFilter($_REQUEST['join_time']);
	$status = $_REQUEST['status'] == null ? '' : sqlUpdateFilter($_REQUEST['status']);
	$addTime = $_REQUEST['addTime'] == null ? '' : sqlUpdateFilter($_REQUEST['addTime']);
	if ($ib->update($userid, $type = 1024, $name, $mobile, $email, $id_number, $pre_money, $join_money, $city, $join_time, $status, $addTime, $db, $id)) {
		//			if($type==1){
		$sql = "update user set type=1024 where id=" . $userid;
		//			}else{
		//				$sql = "update user set type=2048 where id=".$userid;
		//			}
		$db->query($sql);
		redirect("?module=agent_info_set&id=" . $id, "操作成功");
		return;
	} else {
		redirect("?module=agent_info_set&id=" . $id, "系统忙,操作失败");
		return;
	}
}
?>
<form action="?module=agent_info_set" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="edit">
	<input type="hidden" name="id" value="<?php echo $obj->id;?>">
	<input type="hidden" name="userid" value="<?php echo $obj->userid;?>">
	<div id="mainCol" class="clearfix">
		<div class="regInfo">
			<div class="content_title">编辑</div>
			<dl class="ott">
				<dd>
					<ul class="ottList">
						<li>
							<label id="name">真实姓名:</label>
							<?php echo $obj->name; ?>
							<div class="clear"></div>
						</li>
						<li>
							<label id="name">手机号码:</label>
							<?php echo $obj->mobile; ?>
							<div class="clear"></div>
						</li>
						<li>
							<label id="name">邮箱:</label>
							<?php echo $obj->email; ?>
							<div class="clear"></div>
						</li>
						<li>
							<label id="name">身份证号码:</label>
							<?php echo $obj->id_number; ?>
							<div class="clear"></div>
						</li>
						<!--<li>
						<label id="name">分销商类型:<font style="color:#f00;">*</font></label>
						<select name="type">
						<option value="1" <?php if($obj->type==1){echo "selected;";}?>>普通分销商</option>
						<option value="2" <?php if($obj->type==2){echo "selected;";}?>>高级分销商</option>
						</select>
						<div class="clear"></div>
						</li>-->
						<li>
							<label id="name">保证金:<font style="color:#f00;">*</font></label>
							<input type="text" id="pre_money" value="<?php echo $obj->pre_money; ?>" name="pre_money" class="regTxt" />
							<div class="clear"></div>
						</li>
						<li>
							<label id="name">加盟费:<font style="color:#f00;">*</font></label>
							<input type="text" id="join_money" value="<?php echo $obj->join_money; ?>" name="join_money" class="regTxt" />
							<div class="clear"></div>
						</li>
						<!--<li>
						<label id="name">代理城市:<font style="color:#f00;">*</font></label>
						<input type="text" id="city" value="<?php echo $obj->city; ?>" name="city" class="regTxt" />
						<div class="clear"></div>
						</li>
						<li>
						<label id="name">加盟时间:<font style="color:#f00;">*</font></label>
						<input type="text" id="join_time" value="<?php echo $obj->join_time; ?>" name="join_time" class="regTxt" />
						<div class="clear"></div>
						</li>-->
					</ul>
				</dd>
			</dl>
			<div class="clear"></div>
			<p style="float:left; padding-left:10%;"></p>
			<p class="continue">
				<input type="submit" class="continue" id="btn_next" value=" 确定 " />
				<input type="reset" class="continue" id="btn_next" value=" 重置 " />
			</p>
		</div>
	</div>
</form>