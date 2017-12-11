<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>

<div class="index-search prolist-search" onClick="showSearch()"><i></i><?php echo $key;?></div>

<div class="proList">
<?php if($productList==null){echo "<p class='tips-null'>没有相关记录</p>";} else {?>
    <ul class="clearfix">
    <?php foreach($productList as $product){ ?>
    	<li>
            <a href="product_detail.php?product_id=<?php echo $product->product_id;?>">
                <div class="proList-img">
					<?php renderPic($product->image, 'small', 1, array('w'=>154,'h'=>154), array('cls'=>'product_02-Pic-color02'));?>
                </div>
                <p class="proList-title"><?php if(mb_strlen($product->name,'utf-8')>18){ echo mb_substr($product->name,0,18,'utf-8'),'...';}else{ echo $product->name;};?></p>
                <div class="proList-info">
                    <span class="proList-price">￥<?php echo number_format($product->price,2);?><?php echo $product->brand;?></span>
                </div>
            </a>
        </li>
    <?php }?>
    </ul>
<?php }?>
</div>
<?php include TEMPLATE_DIR.'/footer_web.php'; ?>

<!--搜索-->
<div class="index-search-bg">
	<form action="product_search.php" method="get" id="searchForm">
        <div class="index-search-main">
            <div class="txt"><input type="search" name="key" placeholder="请输入商品关键字" /></div>
			<input type="button" value="取消" class="btn" onClick="hideSearch()" />
		</div>
    </form>
</div>

<script>
function showSearch(){
	$(".index-search-bg").fadeIn("fast",function(){
		$("input[name='key']").trigger("focus");
	});
	$(".view,.right_bottom_nav,.proList,.footer").addClass("blur");
}
function hideSearch(){
	$(".index-search-bg").fadeOut("fast");
	$(".view,.right_bottom_nav,.proList,.footer").removeClass("blur");
}
</script>
<?php include_once('common_footer.php');?>
