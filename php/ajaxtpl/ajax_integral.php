<?php
define('HN1', true);
require_once('../global.php');

$UserModel = D('User');
$IntegralPayModel = D('IntegralPay');
$IntegralRecordModel = D('IntegralRecord');

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=user");
	return;
}

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

$type = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 1;

$sql = "select c.integral,c.type,c.addtime,c.color from ".
			  "(select '1' color,concat('-',a.integral) integral,a.type type,a.addtime addtime FROM ".T('integral_pay')." as a where a.userid='".$userid."' ".
			  "UNION all ".
			  "select '2' color,concat('+',b.integral) integral,b.type type,b.addtime addtime FROM ".T('integral_record')." as b where b.userid='".$userid."') ".
			  "as c order by c.addtime desc";
$obj = $UserModel->get(array('id'=>$userid));
?>
<?php 
if($type == 1)
{
	$pager_all = $UserModel->query($sql,false,true,$page,15);
	foreach ($pager_all['DataSet'] as $row) {
?>
	<tr>
		<td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
		<td class="integral-txt" ><?php if($row->color=="1"){echo $IntegralPayType[$row->type];}else{echo $IntegralType[$row->type];}?></td>
		<td class="integral-txt"><font color="<?php if($row->color=="1"){echo "#f60";}else{echo "#666";}?>"><?php echo intval($row->integral);?></font></td>
	</tr>           
<?php }
}
?>
<?php 
if($type == 2)
{
	$pager_records = $IntegralRecordModel->gets(array('userid'=>$userid),array('id'=>'desc'),$page,15);
	foreach ($pager_records['DataSet']  as $row) { 
?>
	<tr>
		<td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
		<td class="integral-txt"><?php echo $IntegralType[$row->type];?></td>
		<td class="integral-txt"><font color="#f60">+<?php echo intval($row->integral);?></font></td>
	</tr>
<?php }
}
?>
<?php 
if($type == 3)
{
	$pager_pay = $IntegralPayModel->gets(array('userid'=>$userid),array('id'=>'desc'),$page,15);
	foreach ($pager_pay['DataSet'] as $row) { 
?>
    <tr>
         <td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
         <td class="integral-txt"><?php echo $IntegralPayType[$row->type];?></td>
         <td class="integral-txt"><font color="#f60">-<?php echo intval($row->integral);?></font></td>
    </tr>
<?php }
} 
?>