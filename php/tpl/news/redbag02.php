<?php include_once('common_header.php');?>
<style type="text/css">
*{ margin:0; padding:0;}
img{ border:none;}
.red_bag_box{ width:320px; height:auto; margin:0 auto;}
.djj_title{width:100%; height:178px; background:#e26d27;color:#fff; font-size:30px; font-weight:bold; text-align:center;line-height:178px;}
</style>

<?php include_once('loading.php');?>
<div class="red_bag_box">
    	<div class="djj_title">
        	<div><font style="font-size:70px; "><?php echo $redbagPrize[$obj->prize]?></font>&nbsp;现金券</div>
        </div>
        <div><img src="res/images/red-bag-05.png" /></div>
        <div><img src="res/images/red-bag-06.png" usemap="#Map" border="0" />
          <map name="Map" id="Map">
            <area shape="rect" coords="14,24,310,94" href="http://mp.weixin.qq.com/s?__biz=MzA4MzU5NzMxNQ==&mid=202906289&idx=2&sn=819f4a6a263f2c3b76c92829935a9ce7#rd" />
          </map>

    </div>
</div>
<?php include_once('common_footer.php');?>
