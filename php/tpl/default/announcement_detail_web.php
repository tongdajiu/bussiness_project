<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="top_nav">
	<div class="top_nav_title"><?php echo $announcement_content->title?></div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
<div class="index-wrapper">
    <div class="message-list">

	    <!--<div class="list02-pic-txt">
	    	<p class="list02-pic-txt_01" style="text-align:center"><?php echo $article_content->title?></p>
	    </div>-->

	    <div style="padding:10px;">
	    	<?php echo $announcement_content->content;?>
	    </div>
	</div>
</div>
<?php include "tpl/footer_web.php";?>
<?php include_once('common_footer.php');?>