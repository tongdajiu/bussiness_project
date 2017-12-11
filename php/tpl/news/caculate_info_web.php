<?php include_once('common_header.php');?>
<link href="res/css/y-style.css" rel="stylesheet" type="text/css" />
<?php include_once('loading.php');?>
<div class="head-red">
	<span class="logo-style"><a href="javascript:window.history.back(-1);"><img src="res/images/return-btn.png" width="23" /></a></span>
    <div class="title-style">计算结果</div>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#fffdd7" style="font-size:12px;">
	<tr align="center" valign="middle">
    <td class="js-td border-right-down" width="25%">云购时间</td>
    <td class="border-right-down bg-jt" width="25%">&nbsp;</td>
    <td class="border-right-down orange-line " width="25%">转换数据</td>
    <td class="border-right-down" width="25%">会员帐号</td>
  </tr>
<?php foreach($last_records as $record){ ?>
  <tr align="center" valign="middle">
    <td class="js-td border-right-down" width="25%"><?php echo date('Y-m-d',$record->addtime);?></td>
    <td class="border-right-down bg-jt" width="25%"><?php echo date('H:i:s',$record->addtime);?></td>
    <td class="border-right-down orange-line " width="25%"><?php echo date('YmdHis',$record->addtime);?></td>
    <td class="border-right-down" width="25%"><?php echo $record->name;?></td>
  </tr>
<?php } ?>
</table>
<div class="arrow-up"></div>
<div class="middle-con" style="text-align:left;">
   <div class="shop-detail-box" style="margin-top:0; margin-bottom:0 ">
   <p style="padding-top:11px;">1、求和：<?php echo $total_time;?>（上面<?php echo $count;?>条云购记录时间取值相加之和）</p>
   <p>2、取余：<?php echo $total_time;?>（<?php echo $count;?>条时间记录之和）%<?php echo $obj_phase->total_amount;?>（本商品总需参与人次）=<?php echo ($total_time%$obj_phase->total_amount) ?>（余数）</p>
    <p style="padding-bottom:11px;">3、结果：<?php echo ($total_time%$obj_phase->total_amount)?>（余数）+100000001=<?php echo (string)($total_time%$obj_phase->total_amount+100000001)?>（最终结果）</p>
   </div>
</div>
<?php include "main_menu.php";?>
<?php include_once('common_footer.php');?>