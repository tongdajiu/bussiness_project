<form action="?module=agent_application_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
    <input type="hidden" name="act" value="ustatus_save">
    <input type="hidden" name="id" value="<?php echo $obj_status->id;?>">
    <input type="hidden" name="userid" value="<?php echo $obj_status->userid;?>">
    <div id="mainCol" class="clearfix">
        <div class="regInfo">
            <div class="content_title">分销商申请信息编辑</div>
            <dl class="ott">
                <dd>
                    <ul class="ottList">                      
                        <li>
                            <label id="name">真实姓名:</label>
                            <p id="name"> <?php echo $obj_status->name; ?></p>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label id="name">手机号码:</label>
                            <p id="mobile" ><?php echo $obj_status->mobile; ?></p>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label id="name">身份证号码:</label>
                            <p id="id_number" ><?php echo $obj_status->id_number; ?></p>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <label id="name">邮箱:</label>
                            <p id="email" ><?php echo $obj_status->email; ?></p>
                            <div class="clear"></div>
                        </li>

                        <li>
                            <?php if($obj_status->author_status !=0){?>
                                <label id="name">审核:</label>
                                <p id="author_status">
                                <?php
                                switch($obj_status->author_status){
                                    case 0;
                                        echo "未审核";
                                        break;
                                    case 1;
                                        echo "已认证";
                                        break;
                                    case 2;
                                        echo "认证不通过";
                                        break;
                                }
                                ?>
                                </p>
                            <?php }?>
                            <div class="clear"></div>
                        </li>
                        <li>
                            <?php if($obj_status->author_status == 0){?>
                            <label id="name">审核:</label>
                            <select id="author_status" name="author_status" class="select" style="WIDTH: 100PX;">
                               <option value="0"<?php if($obj_status->author_status == 0){echo "selected";}?> >待审核</option>
                               <option value="1"<?php if($obj_status->author_status == 1){echo "selected";}?> >验证通过</option>
                               <option value="2"<?php if($obj_status->author_status == 2){echo "selected";}?> >验证不通过</option>
                            </select>
                            <?php }?>
                            <div class="clear"></div>
                        </li>
                        <li id="remark"<?php if($obj_status->remark==''){?> style="display:none"<?php } ?>>
                            <label id="name">原因:</label>
                            <?php if($obj_status->author_status == 0){ ?>
                                <input type="text" value="<?php echo $obj_status->remark; ?>" name="remark" class="regTxt" />
                            <?php }else{ ?>
                                <?php echo $obj_status->remark;?>
                            <?php } ?>
                            <div class="clear"></div>
                        </li>

                        <label id="name">申请时间:</label>
                            <?php echo date('Y-m-d H:i:s', $obj_status->addTime);?>
                            <div class="clear"></div>
                        </li>
                    </ul>
                </dd>
            </dl>
            <div class="clear"></div>

            <p style="float:left; padding-left:10%;"></p>
            <?php if($obj_status->author_status ==0){?>
            <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
            <?php }?>
        </div>
    </div>
</form>
<script>
$(function(){
	$("#author_status").on("change", function(){
        ($(this).val() == 2) ? $("#remark").show() : $("#remark").hide();
	});
});
</script>