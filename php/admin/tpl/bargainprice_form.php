<style type="text/css">
    .regInfo dl.ott dd .regTxt{width:50px;}
</style>
<form action="" id="form" class="cmxform" method="post">
    <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
    <input type="hidden" name="data[product_id]" value="<?php echo $productId;?>" />

    <div id="mainCol" class="clearfix">
        <div class="regInfo">
            <div class="content_title">产品特价</div>
            <dl class="ott">
                <dd>
                    <ul class="ottList">
                        <li>
                            <label class="labelName">属性:</label>
                            <select name="data[product_attr_id]" id="attr-list">
                                <?php foreach($attrMap as $k => $v){ ?>
                                    <option value="<?php echo $k;?>"<?php echo $selAttr[$v['product_attr_id']];?>><?php echo $v['attr'];?></option>
                                <?php } ?>
                            </select>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">开始时间:</label>
                            <input type="text" name="data[start_time]" id="stime" class="wdatePicker" style="width:160px;background-position:145px center;" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'etime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sTime;?>" />
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">结束时间:</label>
                            <input type="text" name="data[end_time]" id="etime" class="wdatePicker" style="width:160px;background-position:145px center;" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'stime\');}', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $eTime;?>" />
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName"><font style="color:#f00;">*</font>价格:</label>
                            <input type="text" name="data[price]" class="regTxt short" value="<?php echo $info['price'];?>" />
                            &nbsp;<span id="note-price"></span>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">库存:</label>
                            <input type="text" name="data[store]" class="regTxt short" value="<?php if($info['store']>=0) echo $info['store'];?>" />
                            &nbsp;不填则为普通价格的库存&nbsp;&nbsp;
                            <span id="note-store"></span>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </dd>
            </dl>
            <p class="continue"><input type="submit" class="continue" value=" 确定 " /><input type="button" id="btn-cancel" class="continue" value=" 取消 " /></p>
        </div>
    </div>
</form>

<script language="javascript" src="<?php echo __UTILS__;?>/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" src="<?php echo __JS__;?>/validator/local/zh_CN.js"></script>
<script language="javascript">
var attrMap = <?php echo json_encode($attrMap);?>;
$(function(){
    $("#form").validate({
        rules: {
            "data[price]": {
                required: true
            },
            "data[store]": {
                digits: true
            }
        }
    });

    $("#btn-cancel").on("click", function(){
        location.href = "<?php echo __CUR_MODULE;?>&id=<?php echo $productId;?>";
    });

    $("#attr-list").on("change", function(){
        noteAttr();
    });

    noteAttr();
});

function noteAttr(){
    var attrId = $("#attr-list").find("option:selected").val();
    $("#note-price").html("普通价格:<span style='color:#f00'>"+attrMap[attrId]["price"]+"</span>");
    $("#note-store").html("当前库存总量:<span style='color:#f00'>"+attrMap[attrId]["store"]+"</span>");
}
</script>