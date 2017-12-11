<div class="content_title">
    商品：<?php echo $product->name;?> 特价
    <a href="?module=product_action" class="content_title_back"><<返回产品列表</a>
</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="<?php echo __CUR_MODULE;?>&act=add&pid=<?php echo $id;?>">添加特价</a>
</div>

<div id="tablewrapper">
    <form id="form-list" action="<?php echo __CUR_MODULE;?>&act=del" method="post">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
                <tr>
                    <th width="50"><h3></h3></th>
                    <th><h3>有效期</h3></th>
                    <th><h3>属性</h3></th>
                    <th><h3>特价</h3></th>
                    <th><h3>库存</h3></th>
                    <th><h3>状态</h3></th>
                    <th><h3>操作</h3></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $v){ ?>
                    <tr>
                        <td><input type="checkbox" name="id[]" value="<?php echo $v['id'];?>" rel="item-ckb" /></td>
                        <td>
                            <?php
                            if($v['start_time'] && $v['end_time']){
                                echo date('Y-m-d H:i:s', $v['start_time']).' 至 '.date('Y-m-d H:i:s', $v['end_time']);
                            }elseif(empty($v['start_time']) && $v['end_time']){
                                echo date('Y-m-d H:i:s', $v['end_time']).' 以前';
                            }elseif(empty($v['end_time']) && $v['start_time']){
                                echo date('Y-m-d H:i:s', $v['start_time']).' 以后';
                            }else{
                                echo '永久有效';
                            }
                            ?>
                        </td>
                        <td><?php echo $v['attrname'];?></td>
                        <td><?php echo $v['price'];?></td>
                        <td><?php if($v['store']>=0) echo $v['store'];?></td>
                        <td>
                            <?php if($v['end_time'] && ($v['end_time'] < $time)){ ?>
                                <span style="color:#f00">已过期</span>
                            <?php }elseif($v['start_time'] && ($v['start_time'] > $time)){ ?>
                                <span style="color:#00f">未到期</span>
                            <?php }else{ ?>
                                正常
                            <?php } ?>
                        </td>
                        <td>
                            <a href="<?php echo __CUR_MODULE;?>&act=edit&pid=<?php echo $id;?>&id=<?php echo $v['id'];?>">修改</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter" style="padding-left:20px;">
        <input type="checkbox" id="all-ckb" />
        <label for="all-ckb">全选</label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:;" id="btn-del">删除</a>
    </div>
</div>
<script language="javascript" src="<?php echo __JS__;?>/jquery.selectAll.js"></script>
<script language="javascript">
$(function(){
    $.selectAll({"allId":"all-ckb", "itemRel":"item-ckb"});

    $("#btn-del").on("click", function(){
        var selAll = false;
        $(":checkbox[rel='item-ckb']").each(function(){
            if($(this).is(":checked")){
                selAll = true;
                return;
            }
        });
        if(!selAll){
            alert("请选择要删除的信息");
            return;
        }else if(confirm("确定要删除吗？")){
            $("#form-list").submit();
        }
    });
});
</script>