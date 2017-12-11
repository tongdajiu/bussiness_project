<?php if(count($commentList)==0){ ?>
	<p class="tips-null">暂无评论</p>
<?php }else{?>
<ul class="pro_comments">
	<?php
	foreach($commentList as $comment){ ?>
	<li>
		<div class="pro_comments_name"><?php echo hide_name($comment->shipping_firstname);?></div>
    	<div class="pro_comments_txt"><?php echo $comment->comment;?></div>
        <div class="pro_comments_time"><?php echo date('Y-m-d H:i:s',$comment->addtime);?></div>
	</li>
	<?php }?>
</ul>
<?php } ?>