<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<style type="text/css">
#tablelocation{text-align:right;padding:10px;line-height:28px;}
#tablelocation p a{display:inline-block;width:28px;height:28px;line-height:28px;text-align:center;border:1px solid #ddd;color:#666;font-size:14px;}
</style>
<div class="top_nav">
	<div class="top_nav_title">客户浏览产品记录</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="integral-wrapper">
	<div class="integral-Record" id="tabs">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
            <tr>
            	<td class="integral-title">用户</td>
                <td class="integral-title">产品</td>
                <td class="integral-title">时间</td>
            </tr>
            <?php if ($recordsList['DataSet'] != null ){ ?>
    			<?php
    			foreach ($recordsList['DataSet'] as $row) {
    				$obj_product = $ProductModel->get($arrWhere=array('product_id'=>$row->product_id));
    			?>
                    <tr>
                       	<td class="integral-txt"><?php echo $obj_user->name?></td>
                       	<td class="integral-txt" ><?php echo $obj_product->name;?></td>
                       	<td class="integral-txt" ><?php echo date('Y-m-d H:i:s',$row->addtime);?></td>
                    </tr>
                <?php }?>
            <?php }else{ ?>
                <tr>
                    <td colspan="3" class="tips-null">暂无记录</td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
    <?php if ( $recordsList['DataSet'] != null ){ ?>
    <div id="tablelocation">
		<p>共<?php echo $recordsList['RecordCount']; ?>条纪录，当前第<?php echo $recordsList['CurrentPage']; ?>/<?php echo $recordsList['PageCount']; ?>页，每页<?php echo $recordsList['PageSize']; ?>条纪录</p>
        <p>
			<a href="<?php echo $url . $recordsList['First']; ?>">|&lt;</a>
			<a href="<?php echo $url . $recordsList['Prev']; ?>">&lt;</a>
			<a href="<?php echo $url . $recordsList['Next']; ?>">&gt;</a>
			<a href="<?php echo $url . $recordsList['Last']; ?>">&gt;|</a>
		</p>
    </div>
    <?php } ?>
</div>
<?php include "footer_web.php"; ?>
<?php include_once('common_footer.php');?>
