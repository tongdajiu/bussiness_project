<?php
define('HN1', true);
require_once ('../global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

$myself = isset($_GET['myself']) ?	true : false;
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : "list";

$user = $_SESSION['userInfo'];

if ($user != null)
{
	$userid = $user->id;
}
else
{
	redirect("login.php?dir=agent_user");
	return;
}

//获取已添加的商品id
$product_ids = $db->get_results("select product_id from shop_product where uid={$userid}");
if(is_array($product_ids))
{
	foreach($product_ids as $row)
	{
		$arr[] = $row->product_id;
	}

	$product_ids = implode(",",$arr);
}
else
{
	$product_ids = 0;
}

//模糊搜索商品名称
$name 	= isset($_GET['name']) ? sqlUpdateFilter(trim($_GET['name'])) : '';
//页码
$page 	= isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

//排序参数
$sell 	= isset($_GET['sell']) 	? true : false;		//销量
$cnum	= isset($_REQUEST['cnum']) 	? true : false;		//评论数
$m		= isset($_REQUEST['m'])		? sqlUpdateFilter(trim($_REQUEST['m'])) : '';	//价格

$strSQL = "select product_id,image,name,price,sell_number,(select count(id) as num from comment where product_id = product.product_id) as `comment_num` from product where product_id not in ({$product_ids}) and status=1";

if($name != '')
{
	$strSQL .= " and name like '%{$name}%'";
}

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
		$url .= "&m=up";
		$strSQL .= " order by price desc";
	}
	else
	{
		$url .= "&m=down";
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
                <a href="shop_product.php?myself&act=post&pid=<?php echo $row->product_id;?>" class="proList-add">添加</a>
            </div>
            </a>
		</li>
		<?php } } ?>

	</ul>
