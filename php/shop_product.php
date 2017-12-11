<?php
define('HN1', true);
require_once ('./global.php');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');

include "common.php"; //设置只能用微信窗口打开

$ShopModel = M('shop');
$ShopProductModel = M('shop_product');

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

if($myself){

	switch($act)
	{
		case 'post':
			$pid 	= isset($_GET['pid']) ? intval($_GET['pid']) : '';
			$name 	= isset($_GET['name']) ? sqlUpdateFilter(trim($_GET['name'])) : '';
			if(empty($pid))
			{
				redirect("shop_product.php?myself","添加失败,缺少商品id");
				return;
			}
			$rs = $ShopProductModel->get(array('uid'=>$userid,'product_id'=>$pid));

			if(!empty($rs))
			{
				if($name!='')
				{
					redirect("shop_product.php?myself&name={$name}","添加失败,商品已存在");
				}
				else
				{
					redirect("shop_product.php?myself","添加失败,商品已存在");
				}
				return;
			}

			$arrParam = array(
				'uid'			=>	$userid,
				'product_id'	=>	$pid,
				'addtime'		=>	time()
			);

			$shop_product_id = $ShopProductModel->add($arrParam);

			if($shop_product_id > 0)
			{
				if($name!='')
				{
					redirect("shop_product.php?myself&name={$name}","添加商品成功");
				}
				else
				{
					redirect("shop_product.php?myself","添加商品成功");
				}

				return;
			}
			else
			{
				if($name!='')
				{
					redirect("shop_product.php?myself&name={$name}","添加商品失败");
				}
				else
				{
					redirect("shop_product.php?myself","添加商品失败");
				}

				return;
			}
		break;

		case 'del':
			$id 	= isset($_GET['id']) ? intval($_GET['id']) : '';

			if(empty($id))
			{
				redirect("shop_edit.php?myself","删除失败,缺少id");
				return;
			}
			$rs = $ShopProductModel->get(array('id'=>$id));

			if(empty($rs))
			{
				redirect("shop_edit.php?myself","删除失败,商品已不存在");
				return;
			}


			$shop_product_id = $ShopProductModel->delete(array('id'=>$id));

			if($shop_product_id > 0)
			{
				redirect("shop_edit.php?myself","删除成功");
				return;
			}
			else
			{
				redirect("shop_edit.php?myself","删除失败");
				return;
			}
		break;

		default:
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

			//排序参数
			$sell 	= isset($_GET['sell']) 	? true : false;		//销量
			$cnum	= isset($_GET['cnum']) 	? true : false;		//评论数
			$m		= isset($_GET['m'])		? sqlUpdateFilter(trim($_GET['m'])) : '';	//价格

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
					$strSQL .= " order by price desc";
				}
				else
				{
					$strSQL .= " order by price asc";
				}
			}

			$pager = get_pager_data($db, $strSQL, $page=1,$per = 4);
			include TEMPLATE_DIR.'/shop_product_web.php';
		break;
	}
}
?>