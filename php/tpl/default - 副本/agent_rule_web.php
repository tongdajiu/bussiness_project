<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">分销规则说明</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="order-wrapper">
	<div style="background-color:#FFF;padding:10px;color:#666;">
		<div style="text-align:center;">
			
			<p style="text-align:left;font-size:12px;line-height:30px;"><b><?php echo $obj->title;?></b><br/>
				<div style="text-align:left;padding: 10px;border: #666 2px solid;-webkit-border-top-right-radius: 8px;-webkit-border-top-left-radius: 8px;-webkit-border-radius: 8px;line-height:15px;">
				<?php echo $obj->content;?>
				</div>
			</p>
			
			<br/>
			<p style="text-align:left;font-size:12px;line-height:15px;">
				<font style="color:#F00">*</font>&nbsp;<?php echo $gSetting['site_name'];?>保留最终解释权以及对本规则做出适当修改之权利。
			</p>
		</div>
        <div class="clear"></div>
    </div>
</div>
<?php include "footer_web.php";?>
<?php include_once('common_footer.php');?>
