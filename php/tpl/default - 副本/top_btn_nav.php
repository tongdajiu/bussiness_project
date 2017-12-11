
<?php include_once('loading.php');?>
<div class="top_btn_nav">
	<a href="user.php" class="top_btn_member"></a>
	<a href="javascript:showSearch();" class="top_btn_search"></a>
</div>

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
	$(function(){
		//加载右侧会员中心菜单
		$(".side_menu_ul").load("user.php .member-list ul")
	});

	function showSearch(){
		$(".index-search-bg").fadeIn("fast",function(){
			$("input[name='key']").trigger("focus");
		});
		$(".view,.right_bottom_nav,.pro_bottom_bar,.footer_memu").addClass("blur");
	}
	function hideSearch(){
		$(".index-search-bg").fadeOut("fast");
		$(".view,.right_bottom_nav,.pro_bottom_bar,.footer_memu").removeClass("blur");
	}
</script>