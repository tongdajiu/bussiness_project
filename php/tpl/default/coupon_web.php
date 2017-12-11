<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">优惠劵管理</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="index-wrapper">
	<div class="u-txt">
        <p class="add-txt01"><?php echo $_SESSION['userInfo']->name;?>，</p>
        <!--<p class="u02-txt03">您现有的积分：<font color="#e8270c"><?php echo $obj_user->integral;?>分</font></p>-->
        <p class="u02-txt03">您的优惠劵：<font color="#e8270c"><?php echo count($couponList);?></font>张</p>
    </div>
</div>

<div class="index-wrapper" >
	<div class="u-txt">
	<p class="add-txt01">优惠劵激活</p>
    </div>
    <div class="clear"></div>
    <form action="" method="post">
        <div class="u-value">
            <input id="number_coupon" name="number_coupon" type="text" value="" class="add-txt-number" placeholder="请填写你的优惠劵号"/>
        </div>
        <input name=""  style="display:block;margin:0 auto;" type="submit" value="确认激活" class="add-button" />
    </form>
</div>


<?php include_once('common_footer.php');?>
