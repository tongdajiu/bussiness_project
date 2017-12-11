<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$user = $_SESSION['userInfo'];
if($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=agent_user");
	return;
}

$myself = isset($_REQUEST['myself']) ?	true : false;

/***********************获取商品列表**************************/
//页码
$page 	= isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

//排序参数
$sell 	= isset($_REQUEST['sell']) 	? true : false;		//销量
$cnum	= isset($_REQUEST['cnum']) 	? true : false;		//评论数
$m		= isset($_REQUEST['m'])		? sqlUpdateFilter(trim($_REQUEST['m'])) : '';	//价格

$strSQL = "select sp.id,p.product_id,p.image,p.name,p.price,p.sell_number,(select count(id) as num from comment where product_id = p.product_id) as `comment_num` from product as p,shop_product as sp where sp.uid={$userid} and sp.product_id = p.product_id and p.status=1";

if($sell)
{
	$strSQL .= " order by sell_number desc";
}
if($cnum)
{
	$strSQL .= " order by comment_num desc";
}
if($m != '')
{
	if($m == 'down')
	{
		$strSQL .= " order by price desc";
	}
	else
	{
		$strSQL .= " order by price asc";
	}
}

$pagerList = get_pager_data($db, $strSQL, $page,$per = 4);
?>
<ul class="clearfix">

	<?php if($pagerList['DataSet'] != null){
				foreach($pagerList['DataSet'] as $row){
			?>
        	<li>
        		<a href="product_detail.php?product_id=<?php echo $row->product_id;?>">
                <div class="proList-img"><?php renderPic($row->image, $sizetype='small', $type='product', $size=array(), $info=array(), $echo=true) ?></div>
                <p class="proList-title"><?php echo $row->name;?></p>
                <div class="proList-info">
                    <span class="proList-price">￥<?php echo $row->price;?></span>
                    <p class="proList-sell"><span>评价(<?php echo $row->comment_num;?>)</span>
                    <span>已售(<?php echo $row->sell_number;?>)</span></p>
                    <?php if($myself){?>
                    <a href="shop_product.php?myself&act=del&id=<?php echo $row->id;?>" class="proList-remove">删除</a>
                	<?php } ?>
                </div>
                </a>
            </li>
     <?php } } ?>

</ul>
