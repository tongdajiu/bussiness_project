<link rel="stylesheet" type="text/css" href="<?php echo __UTILS__;?>/cxColor/jquery.cxcolor.css" />
<style type="text/css">
    .data-container{overflow:hidden;}
    .data-container #data-tpl{padding:10px; display:none;}
    .data-container #data-list{width:650px;}
    .cclear{clear:both;}
    .hide{display:none;}
</style>
<div class="content_title">编辑微信消息模板</div>
<form action="?module=wx_msg_tpl" class="cmxform" method="post">
    <input type="hidden" name="flag" value="<?php echo $tpl->flag;?>" />
    <div id="mainCol" class="clearfix">
        <div class="regInfo">
            <dl class="ott">
                <dd>
                    <ul class="ottList">
                        <li>
                            <label class="labelName">模板标识:</label>
                            <?php echo $tpl->flag;?>
                        </li>
                        <li>
                            <label class="labelName">模板名称:</label>
                            <?php echo $tpl->name;?>
                        </li>
                        <li>
                            <label class="labelName">模板ID:</label>
                            <input type="text" value="<?php echo $tpl->tpl_id;?>" name="tplid" class="regTxt" />
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label class="labelName">模板数据:</label>
                            <div class="data-container">
                                <table id="data-list" cellpadding="0" cellspacing="0" border="0" class="tinytable">
                                    <tr>
                                        <th><h3>微信内容标识</h3></th>
                                        <th><h3>本系统内容标识</h3></th>
                                        <th><h3>颜色</h3></th>
                                        <th><h3>内容</h3></th>
                                        <th><h3>操作</h3></th>
                                    </tr>
                                </table>
                                <fieldset id="data-tpl">
                                    <legend>添加模版内容</legend>
                                    <div class="cclear">
                                        <label>本系统所使用标识:</label>
                                        <select id="data-sys-flag" style="width:auto;padding:0;">
                                            <?php foreach($map as $k => $v){ ?>
                                                <option value="<?php echo $k;?>" data-fixtext="<?php echo $v['fixText']?1:0;?>"><?php echo $v['name'];?></option>
                                            <?php } ?>
                                            <!--
                                            <option value="product_name">产品名</option>
                                            <option value="order_no">订单号</option>
                                            <option value="money">金额</option>
                                            <option value="buy_time">购买时间</option>
                                            -->
                                        </select>
                                    </div>
                                    <div id="con-flag" class="cclear hide">
                                    	<label>微信消息模板数据标识名称:</label>
                                        <input type="text" id="data-wx-flag" />
                                    </div>
                                    <div id="con-fixtext" class="cclear hide">
                                        <label>固定内容:</label>
                                        <input type="text" id="data-fixtext" />
                                    </div>
                                    <div class="cclear">
                                        <label>颜色:</label>
                                        <input type="text" id="data-color" class="input_cxcolor" />
                                    </div>
                                    <div class="cclear" style="padding-left:212px;">
	                                    <input type="button" id="btn-data-save" value="确定" />
	                                    <a id="btn-data-cancel" href="#">取消</a>
                                    </div>
                                </fieldset>
                                <a id="btn-data-add" href="#">[+添加]</a>
                            </div>
                        </li>
                    </ul>
                </dd>
            </dl>
            <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
        </div>
    </div>
</form>
<script language="javascript" src="<?php echo __UTILS__;?>/cxColor/jquery.cxcolor.min.js"></script>
<script language="javascript">
var objColor;
$(function(){
    objColor = $("#data-color");
    initDataTpl();
    initDataItems();

    $("#btn-data-add").on("click", function(){
        openDataTpl();
    });
    $("#btn-data-cancel").on("click", function(){
        initDataTpl();
        closeDataTpl();
    });
    $("#btn-data-save").on("click", function(){
        addDataItem();
    });
    $("#data-list").on("click", ".btn-data-del", function(){
        delDataItem(this);
    });
    $("#data-sys-flag").on("change", function(){
        sysFlagTrigger();
    });
});
function addDataItem(){
    var oSysFlag = $("#data-sys-flag");
    var oWxFlag = $("#data-wx-flag");
    var oContent = $("#data-fixtext");
    var sysFlag = oSysFlag.val();
    var wxFlag = oWxFlag.val();
    var color = objColor.val();
    var content = oContent.val();
    if(oSysFlag.find("option:selected").attr("data-fixtext") == 1){
//        oWxFlag.val(sysFlag);
        wxFlag = sysFlag;
    }else{
        oContent.val("");
        if(wxFlag == ""){
            alert("请填写微信模板标识");
            return;
        }
    }

    $("#data-list").append(genDataItem(sysFlag, wxFlag, color, content));

    initDataTpl();
    closeDataTpl();
}
function delDataItem(obj){
    $(obj).parents(".data-item").remove();
}
function initDataTpl(){
    $("#data-wx-flag").val("");
    objColor.cxColor({color:"#000"});
}
function openDataTpl(){
    $("#data-tpl").show();
    $("#btn-data-add").hide();
    sysFlagTrigger();
}
function closeDataTpl(){
    $("#data-tpl").hide();
    $("#btn-data-add").show();
}
function genDataItem(sysF, wxF, clr, con){
    return "<tr class='data-item'>\
        <td>"+sysF+"</td>\
        <td>"+wxF+"</td>\
        <td style='color:"+clr+"'>"+clr+"</td>\
        <td>"+con+"</td>\
        <td>\
            <input type='hidden' name='data_sysflag[]' value='"+sysF+"' />\
            <input type='hidden' name='data_wxflag[]' value='"+wxF+"' />\
            <input type='hidden' name='data_color[]' value='"+clr+"' />\
            <input type='hidden' name='data_content[]' value='"+con+"' />\
            <a href='javascript:;' class='btn-data-del'>删除</a>\
        </td>\
    </tr>";
}
function initDataItems(){
    var dataJson = <?php echo $dataJson;?>;
    for(var o in dataJson){
        $("#data-list").append(genDataItem(o, dataJson[o].key, dataJson[o].color, dataJson[o].content));
    }
}
function sysFlagTrigger(){
    if($("#data-sys-flag").find("option:selected").attr("data-fixtext") == 1){
        $("#con-fixtext").show();
        $("#con-flag").hide();
    }else{
        $("#con-fixtext").hide();
        $("#con-flag").show();
    }
}
</script>