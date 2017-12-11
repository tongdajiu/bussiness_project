<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript">
function buy_now(product_id){
	$.ajax({
		url:'cart.php?act=add&userid=<?php echo $userid;?>&product_id='+product_id,
		type:'POST',
		dataType: 'html',
		error: function(){
     		alert('请求超时，请重新添加');
    	},
    	success: function(result){
			location.href = 'cart.php';
    	}
	});
}
function replace(favorid){
	if(confirm("确定要删除该收藏吗?"))
	{
		$.ajax({
			url:'favorites.php?act=del&id[]='+favorid,
			type:'POST',
			dataType: 'html',
			error: function(){
     			alert('请求超时，请重新添加');
    		},
    		success: function(result){
    			location.href = 'favorites.php';
    		}
		});
	}
	return false;
}
</script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">我的收藏</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="index-wrapper">
	<?php if ( is_array($favoriteList) ){ ?>
	    <div class="favList">
	        <ul>
				<?php
					foreach($favoriteList as $fav){
						$obj_product = $ProductModel->get(array('product_id'=>$fav->product_id));
				?>
			            <li>
			                <div class="favList_l"><a href="product_detail.php?product_id=<?php echo $obj_product->product_id;?>"><?php renderPic($obj_product->image, 'small', 1, array('w'=>85,'h'=>85));?></a></div>
			                <div class="favList_r">
			                    <a href="product_detail.php?product_id=<?php echo $fav->product_id;?>">
			                    	<p class="favList_r_title">
			                    		<?php
			                    			if( mb_strlen($obj_product->name,'utf-8')>8 )
			                    			{
			                    				echo mb_substr($obj_product->name,0,8,'utf-8'),'...';
			                    			}
			                    			else
			                    			{
			                    				echo $obj_product->name;
			                    			}
										?>
									</p>
			                    	<p class="favList_r_price">价格：￥<?php echo number_format($obj_product->price,2);?>元 </p>
			                    </a>
			                	<input type="button" class="u02-button-y" onclick="location='product_detail.php?product_id=<?php echo $obj_product->product_id;?>'" value="购买" />
			                	<input name="" type="submit" class="favorites-button"  onclick="replace(<?php echo $fav->id;?>);" value="删除" />
			                </div>
			            </li>
				<?php } ?>
	        </ul>
	    </div>
    <?php }else{ ?>
		<div class="tips-null">暂无收藏</div>
    <?php } ?>
</div>

<?php include TEMPLATE_DIR.'/footer_web.php'; ?>
<?php include_once('common_footer.php');?>
