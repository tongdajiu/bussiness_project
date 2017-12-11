<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');


$page       = !isset ($_GET['page'])          ? 1 : intval($_GET['page']);
$status     = !isset ($_GET['status'])        ? -1 : intval($_GET['status']);
$category_id= !isset ($_GET['category_id'])   ? 0 : intval($_GET['category_id']);
$product_id = !isset ($_REQUEST['product_id'])? '' : sqlUpdateFilter($_REQUEST['product_id']);
$range_s    = !isset ($_GET['range_s'])       ? "" : $_GET['range_s'];
$act        = !isset ($_REQUEST['act'])       ? "list" : $_REQUEST['act'];
$condition  = !isset ($_REQUEST['condition']) ? '' : sqlUpdateFilter($_REQUEST['condition']);
$keys       = !isset ($_REQUEST['keys']) || $_REQUEST['keys'] == '请输入产品名称' ? '' : sqlUpdateFilter($_REQUEST['keys']);

$objModel   = new  Model($db);

$ProductModel     = D('Product');
$ProductTypeModel = D('ProductType');
$ProductAttrModel = M('product_attr');
$UnitModel        = M('unit');
$AttributeModel   = M('attribute');


$url = "?module=product_action";
$sql = "SELECT p.`product_id`,p.`status`,p.`inventory`,p.`name`,p.`image`,p.`model`,p.`price`,p.`price_old`,p.`viewed`,p.`sorting`,p.`hot`,p.`unit`,p.`tag_title`,p.`category_id`,(SELECT `name` FROM `product_type` WHERE `id`=p.`category_id`) AS typename ,(SELECT `name` FROM `product_type` WHERE `id`=p.`category_id2`) AS classname FROM product AS p where 1=1 ";

if($keys != '' && $keys != '请输入商品名称')
{
	$sql .= " AND  p.name LIKE '%{$keys}%'";
	$url .= "&keys={$keys}";
}
if($category_id !=0){
	$sql .= ' and p.category_id ='.$category_id;
	$url .= "&category_id={$category_id}";
}

$url .= "&page=";
$sql .= " ORDER BY product_id DESC";

 $re_productTypes = $ProductTypeModel->getALL($arrWhere=array('classid'=>0));







switch ($act) {
	/************添加产品页面********/
	case 'add' :
		$product_id = !isset($_GET['product_id'])  ? 0 :  intval($_GET['product_id']);
	    $proList    = $ProductModel->get($arrWhere=array('product_id'=>$product_id));
	    $typeList   = $ProductTypeModel->getALL($arrWhere2=array('classid'=>0));
	    $productAttrList = $ProductAttrModel->getALL($arrWhere1=array('product_id'=>$product_id));
	    $attrList   = $AttributeModel->getALL();
	    $unitList   = $UnitModel->getALL();
		include "tpl/product_add.php";
        break;
	/***********添加页面处理***********/
	case 'add_save' :
		$name  = $_REQUEST['name']  == null ? '' : sqlUpdateFilter($_REQUEST['name']);
		$title = $_REQUEST['title'] == null ? '' : sqlUpdateFilter($_REQUEST['title']);
		$model = $_REQUEST['model'] == null ? '' : sqlUpdateFilter($_REQUEST['model']);
		$image = "";
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			!file_exists(PRODUCT_IMG_DIR) && mkdir(PRODUCT_IMG_DIR, 0777, true);
			!file_exists(PRODUCT_IMG_DIR."large/") && mkdir(PRODUCT_IMG_DIR."large/", 0777, true);
			!file_exists(PRODUCT_IMG_DIR."small/") && mkdir(PRODUCT_IMG_DIR."small/", 0777, true);

			$image = uploadfile("image", PRODUCT_IMG_DIR);
			ResizeImage(PRODUCT_IMG_DIR, PRODUCT_IMG_DIR."large/", $image, "600");
			ResizeImage(PRODUCT_IMG_DIR, PRODUCT_IMG_DIR."small/", $image, "250");
		}
		$category_id       = !isset ($_REQUEST['category_id'])  ? '0' : sqlUpdateFilter(intval($_REQUEST['category_id']));
		$category_id2      = !isset ($_REQUEST['category_id2']) ? '0' : sqlUpdateFilter(intval($_REQUEST['category_id2']));
		$status            = !isset ($_REQUEST['status'])       ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
		$price             = !isset ($_REQUEST['price'])        ? '' : sqlUpdateFilter($_REQUEST['price']);
		$price_old         = !isset ($_REQUEST['price_old'])    ? '' : sqlUpdateFilter($_REQUEST['price_old']);
		$description       = !isset ($_REQUEST['description'])  ? '' : sqlUpdateFilter($_REQUEST['description']);
		$sorting           = !isset ($_REQUEST['sorting'])      ? '0' : sqlUpdateFilter(intval($_REQUEST['sorting']));
		$inventory         = !isset ($_REQUEST['inventory'])    ? '0' : sqlUpdateFilter(intval($_REQUEST['inventory']));
		$unit              = !isset ($_REQUEST['unit'])         ? '' : sqlUpdateFilter(trim($_REQUEST['unit']));
		$standard          = !isset ($_REQUEST['standard'])     ? '' : sqlUpdateFilter($_REQUEST['standard']);
		$brand             = !isset ($_REQUEST['brand'])        ? '' : sqlUpdateFilter($_REQUEST['brand']);
		$origin_place      = !isset ($_REQUEST['origin_place']) ? '' : sqlUpdateFilter($_REQUEST['origin_place']);
		$range_s           = !isset ($_REQUEST['range_s'])      ? '' : sqlUpdateFilter($_REQUEST['range_s']);
		$distribution_date = !isset ($_REQUEST['distribution_date']) ? '' : sqlUpdateFilter($_REQUEST['distribution_date']);
		$random            = !isset ($_REQUEST['random'])       ? '0' : sqlUpdateFilter(intval($_REQUEST['random']));
		$sell_number       = !isset ($_REQUEST['sell_number'])  ? '0' : sqlUpdateFilter(intval($_REQUEST['sell_number']));
		$tag_title   = isset ($_REQUEST['tag_id']) ? $_REQUEST['tag_id'] : '';
		$attrList    = isset ($_REQUEST['attr'])   ? $_REQUEST['attr']   : '';
		$store       = isset ($_REQUEST['store'])  ? $_REQUEST['store']  : '';
		$money       = isset ($_REQUEST['money'])  ? $_REQUEST['money']  : '';

		if ($store != '') {
			$inventory = 0;
			foreach ($store as $invent_num) {
				$inventory += $invent_num;
			}
		}

		$data = array (
			'name' => $name,
			'title' => $title,
			'model' => $model,
			'image' => $image,
			'category_id' => $category_id,
			'category_id2' => $category_id2,
	        'price' => $price,
			'price_old' => $price_old,
			'status' => $status,
			'viewed' => 0,
			'description' => $description,
			'sorting' => $sorting,
			'inventory' => $inventory,
			'unit' => $unit,
			'standard' => $standard,
			'brand' => $brand,
			'origin_place' => $origin_place,
			'range_s' => $range_s,
			'distribution_date' => $distribution_date,
			'random' => $random,
			'sell_number' => $sell_number,
			'tag_title' => implode(",",$tag_title)
		);


		$objModel->startTrans();
		$pid = $ProductModel->add($data);

		if ($attrList != '' && $store != '' && $money != '') {
			foreach ($attrList as $key => $row) {
				$data = array (
					'product_id' => $pid,
					'attr_group' => json_encode($attrList[$key]
				), 'store' => $store[$key], 'price' => $money[$key]);

				if ($ProductAttrModel->add($data) == 0) {

					$objModel->rollback();
					redirect('?module=product_action', "添加产品属性操作失败");
					return;
				}

			}
		}

		if (!empty ($pid)) {

			createAdminLog($db, 3, "添加产品【{$name}】");

			$objModel->commit();
			redirect('?module=product_action', "添加成功");

		} else {
			$objModel->rollback();
			redirect('?module=product_action', "添加失败");
		}
		return;
		break;

	case 'edit' :
    /***********修改页面***********/
    $product_id = !isset($_GET['product_id'])  ? 0 :  intval($_GET['product_id']);
    $proList    = $ProductModel->get($arrWhere=array('product_id'=>$product_id));
    $typeList   = $ProductTypeModel->getALL($arrWhere2=array('classid'=>0));
    $productAttrList = $ProductAttrModel->getALL($arrWhere1=array('product_id'=>$product_id));
    $attrList   = $AttributeModel->getALL();
    $unitList   = $UnitModel->getALL();
    include "tpl/product_edit.php";
	break;

	/************修改处理************/
	case 'edit_save' :
        $product_id      = !isset ($_REQUEST['product_id']) ? '' : sqlUpdateFilter($_REQUEST['product_id']);
		$name      = !isset ($_REQUEST['name']) ? '' : sqlUpdateFilter($_REQUEST['name']);
		$title     = !isset ($_REQUEST['title']) ? '' : sqlUpdateFilter($_REQUEST['title']);
		$model     = !isset ($_REQUEST['model']) ? '' : sqlUpdateFilter($_REQUEST['model']);
		$old_image = !isset ($_REQUEST['old_image']) ? '' : trim($_REQUEST['old_image']);

		$image     = $old_image;
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			//检查图片文件是否存在
			if (file_exists(PRODUCT_IMG_DIR . $old_image)) {
				unlink(PRODUCT_IMG_DIR . $old_image);
				unlink(PRODUCT_IMG_DIR."large/" . $old_image);
				unlink(PRODUCT_IMG_DIR."small/" . $old_image);
			}

			!file_exists(PRODUCT_IMG_DIR) && mkdir(PRODUCT_IMG_DIR, 0777, true);
			!file_exists(PRODUCT_IMG_DIR."large/") && mkdir(PRODUCT_IMG_DIR."large/", 0777, true);
			!file_exists(PRODUCT_IMG_DIR."small/") && mkdir(PRODUCT_IMG_DIR."small/", 0777, true);
			$image = uploadfile("image", PRODUCT_IMG_DIR);
			ResizeImage(PRODUCT_IMG_DIR, PRODUCT_IMG_DIR."large/", $image, "600");
			ResizeImage(PRODUCT_IMG_DIR, PRODUCT_IMG_DIR."small/", $image, "250");
		}

		$category_id  = !isset ($_REQUEST['category_id'])  ? '0' : sqlUpdateFilter(intval($_REQUEST['category_id']));
		$category_id2 = !isset ($_REQUEST['category_id2']) ? '0' : sqlUpdateFilter(intval($_REQUEST['category_id2']));
		$price        = !isset ($_REQUEST['price'])        ?  '' : sqlUpdateFilter($_REQUEST['price']);
		$price_old    = !isset ($_REQUEST['price_old'])    ?  '' : sqlUpdateFilter($_REQUEST['price_old']);
		$status       = !isset ($_REQUEST['status'])       ? '0' : sqlUpdateFilter(intval($_REQUEST['status']));
		$viewed       = !isset ($_REQUEST['viewed'])       ? '0' : sqlUpdateFilter(intval($_REQUEST['viewed']));
		$description  = !isset ($_REQUEST['description'])  ?  '' : sqlUpdateFilter($_REQUEST['description']);
		$sorting      = !isset ($_REQUEST['sorting'])      ? '0' : sqlUpdateFilter(intval($_REQUEST['sorting']));
		$inventory    = !isset ($_REQUEST['inventory'])    ? '0' : sqlUpdateFilter(intval($_REQUEST['inventory']));
		$unit         = !isset ($_REQUEST['unit'])         ?  '' : sqlUpdateFilter($_REQUEST['unit']);
		$sell_number  = !isset ($_REQUEST['sell_number'])  ? '0' : sqlUpdateFilter(intval($_REQUEST['sell_number']));
		$tag_title    = isset ($_REQUEST['tag_id'])  ? $_REQUEST['tag_id']    : '';
		$attrList     = isset ($_REQUEST['attr'])    ? $_REQUEST['attr']    : '';		
		$store        = isset ($_REQUEST['store'])   ? $_REQUEST['store']   : '';
		$money        = isset ($_REQUEST['money'])   ? $_REQUEST['money']   : '';
		$attr_ids     = isset ($_REQUEST['attr_id']) ? $_REQUEST['attr_id'] : '';
		$del_ids      = isset ($_REQUEST['del_ids']) ? $_REQUEST['del_ids'] : '';

		if ($store != '') {
			$inventory = 0;
			foreach ($store as $invent_num) {
				$inventory += $invent_num;
			}
		}

		$data = array (
			'name'        => $name,
			'title'       => $title,
			'model'       => $model,
			'image'       => $image,
			'category_id' => $category_id,
			'category_id2'=> $category_id2,
	        'price'       => $price,
			'price_old'   => $price_old,
			'status'      => $status,
			'viewed'      => $viewed,
			'description' => $description,
			'sorting'     => $sorting,
			'inventory'   => $inventory,
			'unit'        => $unit,
	        'sell_number' => $sell_number,			
			'tag_title'   => empty($tag_title) ? '' : implode(",",$tag_title),
		);

	
		$objModel->startTrans();
        $obj_product    = $ProductModel->get($arrWhere=array('product_id'=>$product_id));

		//将不需要的属性删除
		if (is_array($del_ids)) {
			foreach ($del_ids as $del_id) {
				$ProductAttrModel->delete($arrWhere= array (
					'id' => $del_id
				));
			}

			createAdminLog($db, 3, "删除产品【" . $obj_product->name . "】的属性信息,属性编号id:" . implode(",", $del_ids));

		}
		
		if ($attrList != '' && $store != '' && $money != '') {
			//添加/修改属性
			foreach ($attrList as $key => $row) {
				$str = array (
					'product_id' => $product_id,
					'attr_group' => json_encode($attrList[$key]), 
					'store' => $store[$key], 'price' => $money[$key]);

				//判断是否存在此属性id，存在即为修改，否则为添加
				if (isset ($attr_ids[$key])) {
					$obj_attr = $ProductAttrModel->get( array (
						'id' => $attr_ids[$key]
					));
					$ProductAttrModel->modify( $str, array (
						'id' => $attr_ids[$key]
					),'',true);

					createAdminLog($db, 3, "修改产品【" . $obj_product->name . "】的属性信息,属性编号id:{$attr_ids[$key]}", '', $obj_attr, $str, 'product_attr', true);

				} else {
					$attr_id = $ProductAttrModel->add($str,'','',true);
					createAdminLog($db, 3, "添加产品【" . $obj_product->name . "】的属性信息,属性编号id:{$attr_id}");
				}
			}
		}

		if ($ProductModel->modify($data,$arrWhere=array('product_id' => $product_id))) {

			createAdminLog($db, 3, "修改产品【" . $obj_product->name . "】信息,编号id:{$product_id}", '', $obj_product, $arrParam, 'product');

			$Product = D('Product');
			$Product->cleanBargainPrice($id);

			$objModel->commit();
			redirect("?module=product_action", "修改成功");
			return;
		} else {
			$objModel->rollback();
			redirect("?module=product_action&act=edit&product_id=" . $product_id, "系统忙,操作失败");
			return;
		}
		break;

	case 'del' :
		$product_id = array ();
		$product_id = $_REQUEST['product_id'];
		if (empty ($product_id)) {
			redirect('?module=product_action', "您没选中任何条目");
			return;
		}
		if ($ProductModel->delete($arrWhere=array('product_id' => $product_id))) {

			createAdminLog($db, 3, "删除产品信息,编号id:" . implode(",", $id));

			redirect('?module=product_action', "操作成功");
			return;
		} else {
			redirect('?module=product_action', "系统忙");
			return;
		}
		break;

	default :		
		$url = $url . "&page=";
		$productList = $ProductModel->query($sql,false, true, $page, $perpage=20 );
				
		include "tpl/product_list.php";

}


/**
 * 生成带参数的二维码
 */
function getQRCode($db) {
	$stroe_id = '9'; //商户id        存储在二维码内的参数
	$access_token = get_token(); //获取access_token
	$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
	$array = array (
		"action_name" => "QR_LIMIT_SCENE",
		"action_info" => array (
			"scene" => array (
				"scene_id" => $stroe_id
			)
		)
	);
	echo json_encode($array);
	$res = http_post_data($url, json_encode($array)); //通过CURL传入json到微信接口获取ticket
	print_R($res);

	$temp = explode(",", $res[1]);
	$res = explode(":", $temp[0]);
	$ticket = str_replace('"', '', $res[1]); //获取到用于生成验证码的ticket
	$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
	//得到的二维码链接
	echo $url;
	echo "<img src='$url'/>";

}


?>