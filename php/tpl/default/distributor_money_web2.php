<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">提现记录</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="index-wrapper"  style="
    padding: 15px 0 60px 0;
">
	<div class="u-txt">
		<a href="distributor_money.php?act=add&id=<?php echo $userid;?>" class="skinColor" style="float:right">【申请提现】</a>
   	  	<p class="add-txt01"><?php echo $obj_user->name;?>，欢迎你</p>
    </div>
    <div class="clear"></div>
    <div class="integral-wrapper">
    <?php if(count($moneyList) == 0){ ?>
    <div class="tips-null">暂无提现记录！</div>
    <?php }else{ ?>
    	<div class="integral-Record" id="tabs">
        	<div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
                <tr>
                    <td class="integral-title">手机号</td>
                    <td class="integral-title">申请时间</td>
                    <td class="integral-title">提现金额</td>
                    <td class="integral-title">状态</td>
                    <td class="integral-title">详情</td>
                </tr>
           <?php

                foreach ($moneyList as $row) {?>

                <tr>
                   	<td class="integral-txt" ><?php echo $row->mobile;?></td>
                    <td class="integral-txt" ><?php echo ($row->add_time !=0) ? date('Y-m-d H:i:s',$row->add_time) : '--' ; ?></td>
                    <td class="integral-txt" ><?php echo $row->d_money;?></td>
                    <td class="integral-txt" >
                     <?php
						switch ($row->status) {
							case 0;
								echo "未审核";
								break;
							case 1;
								echo "审核通过";
								break;
							case 2;
								echo "审核失败";
								break;
						}
					?>
                  </td>
	              <td align="center">
	              	<p class="integral-txt" ><a href="distributor_money.php?act=details&id=<?php echo $row->id;?>" class="skinColor">详情</a></p>
	              </td>
             <?php }?>
            </table>
        </div>
      <?php } ?>
    </div>
</div>
<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>

