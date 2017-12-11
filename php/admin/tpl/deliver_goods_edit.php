<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script src="../res/js/jquery.chained.min.js"></script>

<script type="text/javascript">
	$(function(){
		$("#express_type").find("option[value='<?php echo $obj->express_type; ?>']").attr("selected","selected");
	});
</script>
<form action="?module=orders_action" id="regform" class="cmxform" method="post">
    <input type="hidden" name="act" value="deliveredit_save">
    <input type="hidden" name="id" value="<?php echo $order->order_id;?>">
    <div id="mainCol" class="clearfix">
        <div class="regInfo">
            <div class="content_title">发货</div>
            <dl class="ott">
                <dd>
                    <ul class="ottList">
                        <li>
                            <label id="name">订单号:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $order->order_number; ?></strong></label>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label id="name">收货人:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $order->shipping_firstname; ?></strong></label>
                            <div class="clear"></div>
                        </li>
                            <li>
                                <label id="name">收货地址:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $order->shipping_address_1; ?></strong></label>
                                <div class="clear"></div>
                            </li>
                        <li>
                        <label id="name">订单当前状态:</label><label style="vertical-align: middle;line-height:30px;"><strong><?php echo $OrderStatus[$order->order_status_id];?></strong></label>
                            <input type="hidden" name="order_status_id" value="2" />
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label id="name">物流类型:</label>
                            <select id="express_type" name="express_type">
                                <?php while(list($key,$val) = each($ExpressType)){ ?>
                                    <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php } ?>
                            </select>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </dd>
            </dl>
            <div class="clear"></div>
            <div id="tablewrapper">
                <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
                    <thead>
                        <tr>
                            <th><h3>图片</h3></th>
                            <th><h3>名称</h3></th>
                            <th><h3>规格</h3></th>
                            <th><h3>货号</h3></th>
                            <th><h3>价格</h3></th>
                            <th><h3>数量</h3></th>
                            <th><h3>小计</h3></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($products as $pro){
                        ?>
                            <tr>
                                <td><?php echo renderPic($pro->product_image, 'small', 1, array('h'=>100));?></td>
                                <td><?php echo $pro->product_name; ?></td>
                                <td><?php echo $pro->product_model; ?></td>
                                <td><?php echo $pro->model; ?></td>
                                <td><?php echo $pro->product_price;?></td>
                                <td><?php echo $pro->shopping_number;?></td>
                                <td><?php echo number_format($pro->product_price * $pro->shopping_number,2);?></td>
                            </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            <p style="float:left; padding-left:10%;"></p>
            <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 清空 " /></p>
        </div>
    </div>
</form>