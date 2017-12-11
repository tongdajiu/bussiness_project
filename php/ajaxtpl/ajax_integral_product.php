<?php
define('HN1', true);
require_once('../global.php');
require_once MODEL_DIR . '/IntegralProductModel.class.php';

$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);

$integral_product = new IntegralProductModel($db);

$product_addList = $integral_product->gets(array('status'=>1),array('sorting'=>'ASC','id'=>'DESC'),$page,6);
?>

<?php foreach($product_addList['DataSet'] as $product){ ?>
<li>
	<a href="integral_product_detail.php?product_id=<?php echo $product->id;?>">
        <div class="proList-img">
			<?php renderPic($product->image, 'small', 5, array('w'=>154,'h'=>154), array('cls'=>'product_02-Pic-color02'));?>
        </div>
        <p class="proList-title"><?php if(mb_strlen($product->name,'utf-8')>18){ echo mb_substr($product->name,0,18,'utf-8'),'...';}else{ echo $product->name;};?></p>
        <div class="proList-info">
            <span class="proList-price">积分:<?php echo $product->integral;?></span>
        </div>
    </a>
</li>
<?php } ?>