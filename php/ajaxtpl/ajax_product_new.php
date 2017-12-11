<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

//include "common.php";	//设置只能用微信窗口打开
require_once MODEL_DIR . '/GoodsTagModel.class.php';
$category_id = $_REQUEST['category_id'] = null ? '0' : intval($_REQUEST['category_id']);
$page = intval($_REQUEST['page']);
$type = in_array(trim($_GET['t']), array('new')) ? trim($_GET['t']) : '';

$goodstag = new GoodsTagModel($db);
$ProductModel 		= D('Product', $db);
switch($type){
	case 'new':
		$cond = array('status'=>1);
		($category_id > 0) && $cond['category_id'] = $category_id;
		$product_addList = $ProductModel->gets($cond, '`product_id` DESC', $page, 10);
		break;
	default:
		$product_addList = $ProductModel->getList( $category_id, $page, 10 );
		break;
}

?>

<?php foreach($product_addList['DataSet'] as $product){ ?>
<li>
	<a href="product_detail.php?product_id=<?php echo $product->product_id;?>">
        <div class="proList-img">
			<?php renderPic($product->image, 'small', 1, array('w'=>154,'h'=>154), array('cls'=>'product_02-Pic-color02'));?>
        </div>

       	<?php if ( $product->tag_title != null ){ ?>
	       	<div class="proList-label">
	            <?php  $rs = $goodstag->query("SELECT `images`,`title` FROM `goods_tag` WHERE `id` IN ({$product->tag_title})");?>
				<?php foreach( $rs as $info ){ ?>
			    	<div class="proList-label-item">
				    	 <?php if($info->images !=''){ ?>
	           				<img src="../upfiles/label/<?php  echo $info->images;?>"/>
	           			 <?php }else{ ?>
	           				<p><?php echo $info->title;?></p>
	           			 <?php  }?>
	       			</div>
		         <?php  }?>
	       	</div>
       	<?php  }?>

        <p class="proList-title"><?php if(mb_strlen($product->name,'utf-8')>18){ echo mb_substr($product->name,0,18,'utf-8'),'...';}else{ echo $product->name;};?></p>
        <div class="proList-info">
            <span class="proList-price">￥<?php echo number_format($product->price,2);?><?php echo $product->brand;?></span>
        </div>
    </a>
</li>
<?php } ?>