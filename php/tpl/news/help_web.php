<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">帮助中心</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="member-list" style="margin:10px;border-top:none;">
    <ul>
    	<?php
    	if(!empty($articleList)){
		foreach ($articleList as $row) {
		?>
        <li>       
            <a href="help_detail.php?id=<?php echo $row->id;?>"><?php echo $row->title?></a>      
        </li>
		<?php } } ?>
    </ul>
</div>

<?php include TEMPLATE_DIR."/footer_web.php";?>
<?php include_once('common_footer.php');?>
<?php include_once('footer_menu_web_new.php');?>
