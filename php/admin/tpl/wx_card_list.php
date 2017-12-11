<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

//hs.Expander.prototype.onAfterClose = function() {
//    window.location.reload();
//};
</script>
<div class="content_title">卡券管理</div>
<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
					<th><h3>卡券编号</h3></th>
					<th><h3>标题</h3></th>
					<th><h3>库存</h3></th>
					<th><h3>面值</h3></th>
					<th><h3>操作</h3></th>
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
if($card_list != null){
foreach ($card_list['card_id_list'] as $row) {
	$result = get_card_info($row);
//	var_dump($result);
	$info = $result['card']['cash']['base_info'];
	$re_wx_card = $wxcb->detail_cardid($db,$row);
//	print_r($info);
	$i++;
?>
				<tr>
					<td width="35px"><?php echo $i; ?></td>
					<td><?php echo $row; ?></td>
					<td><?php echo $info['title'];?></td>
					<td><?php echo $info['sku']['quantity'];?></td>
					<td><?php echo $re_wx_card->reduce_cost;?>元</td>
					<td>
						<a href="?module=wx_card_detail&card_id=<?php echo $row;?>" class="highslide" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '卡券', width: 550, height: 370} )">查看详情</a>
						<a href="?module=wx_card_qrcode&act=get_qrcode_to_card&card_id=<?php echo $row;?>" class="highslide" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '卡券二维码', width: 550, height: 550} )">查看二维码</a>

						<a href="?module=modify_card_stock_action&card_id=<?php echo $row;?>" class="highslide" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '修改库存', width: 550, height: 200} )">修改库存</a>
						<a href="?module=modify_card_reduce_cost_action&card_id=<?php echo $row;?>" class="highslide" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '修改面值', width: 550, height: 200} )">修改面值</a>
					</td>
				</tr>
<?php
} }
?>
            </tbody>
        </table>
    </form>
</div>
