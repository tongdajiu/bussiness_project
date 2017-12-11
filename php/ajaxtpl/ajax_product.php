<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

//include "common.php";	//设置只能用微信窗口打开
// require_once SCRIPT_ROOT.'../admin/logic/productBean.php';

$ProductModel = D('Product');

$category_id = $_REQUEST['category_id'] = null ? '0' : intval($_REQUEST['category_id']);
$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

// $ib = new productBean();

// $product_addList = $ib->search_list($db,$page,10,$category_id);
$product_addList = $ProductModel->gets($arrWhere=array('category_id'=>$category_id),array('product_id'=>'desc'),$page, $perpage = 10);
?>
<div class="list-product">
        <ul>
<?php foreach($product_addList['DataSet'] as $product){ ?>
            <li class="list-productBg">
                <div class="list-product-L" onclick="javascript:location.href='product_detail.php?product_id=<?php echo $product->product_id;?>'"><img src="product/small/<?php echo $product->image;?>" alt="" width="171" class="shoppingCart-table-Pic02-border"/></div>
                <div class="list-product-R">
                    <a href="product_detail.php?product_id=<?php echo $product->product_id;?>"><p class="list-product-R-tit"><?php if(mb_strlen($product->name,'utf-8')>12){ echo mb_substr($product->name,0,12,'utf-8'),'...';}else{ echo $product->name;};?></p>
                    <?php if($product->hot == 2 && $obj_user != null && $obj_user->type == 1){ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元  <span class="list-product-R-value02">原价：<?php echo $product->price_old;?>元</span></p></a>
                    <?php }else{ ?>
                    	<p class="list-product-R-value">价格：￥<?php echo $product->price;?>元</p></a>
                    <?php } ?>
                    <br />
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="buy_now(<?php echo $product->product_id;?>);" value="加入购物车"/>
                	<input id="list-shoppingCart" name="" type="submit" class="list-product-R-button" onclick="addFavor(<?php echo $product->product_id;?>);" value="加入收藏"/>
                </div>
            </li>
<?php } ?>
        </ul>
    </div>