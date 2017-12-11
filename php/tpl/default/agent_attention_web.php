<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title">下线用户关注公众号情况</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="integral-wrapper">
	<div class="integral-Record" id="tabs">

    	<div class="clear"></div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
            <tr>
            	<td class="integral-title">用户</td>
                <td class="integral-title">等级</td>
            </tr>
            <?php if ( $couponList != null ){ ?>
                <?php
                foreach ($userList as $_user) {
                ?>
                    <tr>
                        <td class="integral-txt"><?php echo $_user['info']['name'];?></td>
                        <td class="integral-txt" ><?php echo $_user['level'];?></td>
                    </tr>
                 <?php }?>
            <?php }else{ ?>
                <tr>
                    <td colspan="2" class="tips-null">暂无记录</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>
