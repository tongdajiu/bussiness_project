<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<?php include_once('loading.php');?>
<div class="list-nav">
	<a href="javascript:window.history.back(-1);" class="top-left top-back">后退</a>
	<a href="user.php" class="top-right top-member">会员中心</a>
    <div class="member-nav-M">提现记录</div>
</div>

<div class="index-wrapper"  style="
    padding: 15px 0 60px 0;
">
	<div class="u-txt">
   	  <p class="add-txt01"><?php echo $obj_user->name;?>，欢迎你</p>
    </div>
    <div class="clear"></div>
     <p class="search" style="float:right"><a href="user_money.php" style="color:#A284FD">【申请提现】</a></p>
    <div class="integral-wrapper">
    	<div class="integral-Record" id="tabs">

        	<div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
                <tr>
                    <td class="integral-title">手机</td>
                    <td class="integral-title">身份证</td>
                    <td class="integral-title">提现金额</td>
                    <td class="integral-title">申请时间</td>
                    <td class="integral-title">状态</td>
                    <td class="integral-title">通过时间</td>
                    <td class="integral-title">打款状态</td>
                    <td class="integral-title">打款时间</td>
                </tr>
           <?php
             foreach ($moneyList as $row) {
           ?>
                <tr>
                   	<td class="integral-txt"><?php echo $row->mobile;?></td>
                   	<td class="integral-txt"><?php echo $row->id_number;?></td>
                   	<td class="integral-txt" ><?php echo "￥ ".number_format($row->money,2);?></td>
                    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->add_time);?></td>
                    <td class="integral-txt" >
                     <?php
                        switch($row->status){
                        case 0;
                            echo "未审核";
                            break;
                        case 1;
                            echo "已审核";
                            break;
                    }?>
                   </td>
                    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->through_time);?></td>
                    <?php if($row->status==1){?>
                    <td class="integral-txt" >
                      <?php
                        switch($row->play_type){
                        case 0;
                            echo "未打款";
                            break;
                        case 1;
                            echo "已打款";
                            break;
                      }?>
                    </td>
                    <?php }?>
                    <?php if($row->status==1){?>
                    <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->play_time);?></td>
                    <?php }?>
                </tr>
             <?php }?>
            </table>
        </div>
    </div>
</div>
<?php include "tpl/footer_web.php"; ?>
<?php include_once('common_footer.php');?>

