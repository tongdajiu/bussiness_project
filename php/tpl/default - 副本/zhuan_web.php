<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<style>
	body{background:#f8f8f8;}
	.bottom_btn{position:fixed;bottom:0;left:0;width:100%;}
</style>
<div class="zhuan">
	<h2>
		<span><?php echo $gSetting['site_name'];?></span>
		推荐你成为分销商
	</h2>
    <div class="privilege">
        <h3 class="privilege_title">分销商特权</h3>
        <ul class="privilege_item">
            <li>
                <i><img src="<?php echo __IMG__;?>/fx_icon1.png" /></i>
                <div class="privilege_item_main">
                    <h4>独立微店</h4>
                    <p>拥有自己的微店及推广二维码</p>
                </div>
            </li>
            <li>
                <i><img src="<?php echo __IMG__;?>/fx_icon2.png" /></i>
                <div class="privilege_item_main">
                    <h4>销售拿佣金</h4>
                    <p>微店卖出商品，您可以获得佣金</p>
                </div>
            </li>
        </ul>

        <p>分销商的微店销售统一由厂家直接收款、直接发货，并提供产品的售后服务，分销佣金由厂家统一设置。</p>
    </div>
</div>
<div style="height:40px;"></div>
<div class="bottom_btn">
    <?php if(empty($apply)){ ?>
	    <a class="zhuan_btn" href="agent_application.php">申请分销</a>
    <?php }else{ ?>
        <a class="zhuan_btn" href="<?php echo $_SERVER['HTTP_REFERER'];?>">申请正在审核，点击返回上一页</a>
    <?php } ?>
</div>
