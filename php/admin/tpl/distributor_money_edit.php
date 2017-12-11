<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="../res/js/jquery.datepick-zh-CN.js"></script>
<link rel="stylesheet" type="text/css" href="../res/css/jquery.datepick.css" />
<form action="?module=distributor_money_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $infoList->id;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<dl class="ott">
<dt><span>1</span>操作</dt>
</dl>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">姓名:</label>
<p id="name"><?php echo $infoList->name;?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">手机:</label>
<p id="mobile" ><?php echo $infoList->mobile;?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">身份证:</label>
<p id="id_number"><?php echo $infoList->id_number;?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">申请金额:</label>
<p id="money"><?php echo $infoList->d_money;?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">提现方式:</label>
<p id="pay_method"><?php echo $Transfers[$infoList->pay_method];?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">提现账号:</label>
<p id="account_number"><?php echo $infoList->account_number;?></p>
<div class="clear"></div>
</li>

<li>
<label id="name">申请时间:</label>
<p id="add_time"><?php echo date('Y-m-d H:i:s',$infoList->add_time); ?></p>
<div class="clear"></div>
</li>

<li>
<?php if($infoList->status ==0){?>
<label id="name">审核状态:<font style="color:#f00;">*</font></label>
<select id="status" name="status" class="select" style="WIDTH: 100PX;">
   <option value="0"<?php if($infoList->status == 0){echo "selected";}?> >未审核</option>
   <option value="1"<?php if($infoList->status == 1){echo "selected";}?> >通过</option>
   <option value="2"<?php if($infoList->status == 2){echo "selected";}?> >不通过</option>
</select>
<div class="clear"></div>
<?php }?>
</li>
<li>
<?php if($infoList->status !=0){?>
<label id="name">审核状态:</label>
<td>
    <?php
        switch($infoList->status){
            case 0;
            echo "未审核";
        break;
            case 1;
            echo "审核通过";
        break;
            case 2;
            echo "审核不通过";
        break;
    }?>
</td>
<?php }?>
<div class="clear"></div>
</li>

<?php if($infoList->status && $infoList->through_time){ ?>
<li>
<label id="name">审核时间:</label>
<p id="through_time"><?php echo date('Y-m-d H:i:s',$infoList->through_time); ?></p>
<div class="clear"></div>
</li>
<?php } ?>

<li>
<label id="name">审核人:</label>
<p id="username" ><?php echo $infoList->username;?></p>
<div class="clear"></div>
</li>

<li>
<?php if($infoList->status ==1 && $_SESSION['myinfo']->id==1 ){?>
<label id="name">打款状态:</label>
<?php if( $infoList->play_type == 0 ){ ?>
	<input type="button" value="点击确认打款" onclick="pay_btn( <?php echo $infoList->id ?> )" />
<?php }else{ ?>
	已打款
<?php }?>
<div class="clear"></div>
<?php }?>
</li>

<li>
<?php if($infoList->status ==1 ){?>
<label id="name">打款时间:</label>
<p  id="play_time"><?php if($infoList->play_type !=0) echo date('Y-m-d H:i:s',$infoList->play_time);?></p>
<div class="clear"></div>
<?php }?>
</li>

<?php if($infoList->status == 0){ ?>
    <li id="remark" style="display:none">
        <label>备注:</label>
        <input type="text" value="<?php echo $infoList->remark;?>" name="remark" class="regTxt" />
        <div class="clear"></div>
    </li>
<?php }elseif($infoList->remark != ''){ ?>
    <li>
        <label>备注:</label>
        <?php echo $infoList->remark;?>
        <div class="clear"></div>
    </li>
<?php } ?>

</ul>
</dd>
</dl>
<div class="clear"></div>
<p style="float:left; padding-left:10%;"></p>
<?php if($infoList->status ==0 ){?>
<p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
<?php }?>
</div>
</div>
</form>
<script>
$(function(){
    $("#status").on("change", function(){
        ($(this).val() == 2) ? $("#remark").show() : $("#remark").hide();
    });
});

function pay_btn(id){
    $.ajax({
        url:  '/admin/index.php?module=distributor_money_action&act=update_play&id=' + id,
        data: 'text',
        success:function(data){
            alert('打款成功');
            location.reload();
        }
    })
}
</script>
