<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

$cart_id = $_GET['card_id'] == null ? '0' : $_GET['card_id'];
$act = $_GET['act'] == null ? 'list' : $_GET['act'];

$result = get_card_info($cart_id);

$info = $result['card']['cash']['base_info'];

?>

<form action="#" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<dl class="ott">
<dt>卡券编号：<?php echo $card_id; ?></dt>
</dl>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">卡券类型: </label><?php echo $result['card']['card_type'] ?>
<div class="clear"></div>
</li>
<li>
<label id="name">卡券标题: </label><?php echo $info['title']; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">副标题: </label><?php echo $info['sub_title']; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">减免金额: </label><?php echo $result['card']['cash']['reduce_cost']/100; ?>元
<div class="clear"></div>
</li>
<li>
<label id="name">抵扣条件: </label><?php echo $result['card']['cash']['least_cost']; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">创建时间: </label><?php echo date('Y-m-d H:i:s',$info['create_time']); ?>
<div class="clear"></div>
</li>
<li>
<label id="name">有效期: </label><?php echo $info['date_info']['fixed_term'].'天'; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">描述: </label><?php echo $info['description']; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">商家名称: </label><?php echo $info['brand_name']; ?>
<div class="clear"></div>
</li>
<li>
<label id="name">操作提示: </label><?php echo $info['notice']; ?>
<div class="clear"></div>
</li>

  </ul>
   </dd>
    </dl>
	<div class="clear"></div>
	</div>
</div>
</form>