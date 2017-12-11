<?php
define('HN1', true);
require_once('../global.php');

$PayRecordsModel = M('pay_records');
$UserModel = D('User');

$user = $_SESSION['userInfo'];
if($user != null){
	$userid = $user->id;
}else{
	redirect("login.php?dir=pay_records");
	return;
}

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$recordsList = $PayRecordsModel->gets(array('userid'=>$userid),array('id'=>'DESC'),$page,15);

$obj_user = $UserModel->get(array('id'=>$userid));

?>


<?php
foreach ($recordsList['DataSet'] as $row) {
?>
<tr>
	<td class="integral-txt"><?php echo $row->order_num;?></td>        
    <td class="integral-txt" ><?php echo "￥ ".number_format($row->money,2);?></td>
    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->addtime);?></td>
</tr>
<?php }?>