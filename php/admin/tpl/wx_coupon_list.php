
<div class="content_title">微信卡券管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=wx_coupon&act=add">添加微信卡券</a>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
            	<tr>
            		<th><h3>序号</h3></th>
            		<th><h3>微信优惠券号</h3></th>
					<th><h3>类型</h3></th>
					<th><h3>使用范围</h3></th>
					<th><h3>展示类型</h3></th>
					<th><h3>商户名字</h3></th>
					<th><h3>卡券名</h3></th>
					<th><h3>卡券使用提醒</h3></th>
					<th><h3>时间的类型</h3></th>
					<th><h3>使用时间</h3></th>
					<th><h3>状态</h3></th>
					<th><h3>查看二维码</h3></th>
					<!--<th><h3>操作</h3></th>-->
            	</tr>
            </thead>
			<tbody>
<?php
$i = 0;
if($pager['DataSet'] != null){
foreach ($pager['DataSet'] as $row) {
	$i++;
?>
				<tr>
					<td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $i; ?></label></td>
					<td><?php echo $row->wx_card_id; ?></td>
					<td>
						<?php
							switch( $row->card_type )
							{
								case 'GROUPON':
									echo '团购券';
								break;

								case 'CASH':
									echo '代金券';
								break;

								case 'DISCOUNT':
									echo '折扣券';
								break;

								case 'GIFT':
									echo '礼品券';
								break;

								case 'GENERAL_COUPON':
									echo '优惠券';
								break;
							}
						?>
					</td>
					<td>
						<?php
							switch( $row->card_type )
							{
								case 'GROUPON':
									echo $row->deal_detail;
								break;

								case 'CASH':
									echo $row->least_cost . ' -- ' . $row->reduce_cost;
								break;

								case 'DISCOUNT':
									echo (100-$row->discount)/10 . '折';
								break;

								case 'GIFT':
									echo $row->gift;
								break;

								case 'GENERAL_COUPON':
									echo $row->default_detail;
								break;
							}
						?>
					</td>
					<td>
						<?php
							switch( $row->code_type )
							{
								case 'CODE_TYPE_TEXT':
									echo '文本';
								break;

								case 'CODE_TYPE_BARCODE':
									echo '一维码';
								break;

								case 'CODE_TYPE_QRCODE':
									echo '二维码';
								break;

								case 'CODE_TYPE_ONLY_QRCODE':
									echo '二维码无code显示';
								break;

								case 'CODE_TYPE_ONLY_BARCODE':
									echo '一维码无code显示';
								break;
							}
						?>
					</td>
					<td><?php echo $row->brand_name; ?></td>
					<td><?php echo $row->title; ?></td>
					<td><?php echo $row->notice; ?></td>
					<td>
						<?php
							switch( $row->type )
							{
								case 'DATE_TYPE_FIX_TIME_RANGE':
									echo '固定日期';
								break;

								case 'DATE_TYPE_FIX_TERM':
									echo '固定时长';
								break;
							}
						?>
					</td>
					<td>
						<?php
							switch( $row->type )
							{
								case 'DATE_TYPE_FIX_TIME_RANGE':
									echo date('Y-m-d',$row->begin_timestamp) . ' -- ' .date('Y-m-d',$row->end_timestamp);
								break;

								case 'DATE_TYPE_FIX_TERM':
									if ( $row->fixed_begin_term == 0 )
									{
										echo "自领取后" . $row->fixed_term . "天内有效";
									}
									if ( $row->fixed_term == 0 )
									{
										echo "自领取后" . $row->fixed_term . "天开始生效";
									}
								break;
							}
						?>
					</td>
					<td><?php echo $row->status == 1 ? '有效' : '无效' ?></td>
					<td>
						<a target="_blank" href="/admin/index.php?module=wx_coupon&act=del&id=<?php echo $row->id; ?>" class="btn btn-red">删除</a>
						<a target="_blank" href="/admin/index.php?module=wx_coupon&act=send&cid=<?php echo $row->wx_card_id; ?>" class="btn btn-blue">查看</a>
					</td>
					<!--<td><a href="?module=<?php echo nowmodule_;?>&act=edit&id=<?php echo $row->id; ?>" style="color:#f00;">编辑</a> | <a href="?module=<?php echo nowmodule;?>&act=del&id[]=<?php echo $row->id; ?>" onclick="javascript:return window.confirm('确定删除？');">删除</a></td> -->
				</tr>
<?php
}}
?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
                <a href="javascript://" onclick="return replace();" >删除</a>
            </div>
        </div>

        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $pager['RecordCount']; ?>条纪录，当前第<?php echo $pager['CurrentPage']; ?>/<?php echo $pager['PageCount']; ?>页，每页<?php echo $pager['PageSize']; ?>条纪录</span>
                <a href="<?php echo '?module=wx_coupon&page=' . $pager['First']; ?>">[第一页]</a>
                <a href="<?php echo '?module=wx_coupon&page=' . $pager['Prev']; ?>">[上一页]</a>
                <a href="<?php echo '?module=wx_coupon&page=' . $pager['Next']; ?>">[下一页]</a>
                <a href="<?php echo '?module=wx_coupon&page=' . $pager['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
