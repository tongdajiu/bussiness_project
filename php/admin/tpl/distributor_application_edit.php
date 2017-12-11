<form action="?module=distributor_application_action" id="regform" class="cmxform" method="post" enctype="multipart/form-data">
<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $info->id;?>">
<input type="hidden" name="userid" value="<?php echo $info->userid;?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">二维码权限审核</div>
 <dl class="ott">
<dd>
<ul class="ottList">
<li>
<label id="name">姓名:</label>
<p id="username"><?php echo $info->name;?></p>
<div class="clear"></div>
</li>
<li>
<label id="name">申请时间:</label>
<p id="add_time"><?php echo date('Y-m-d H:i:s',$info->add_time); ?></p>
<div class="clear"></div>
</li>

<li>
<?php if($info->status == 0){?>
<label id="name">状态:</label>
<select id="status" name="status" class="select" style="WIDTH: 100PX;">
   <option value="0"<?php if($info->status == 0){echo "selected";}?> >未审核</option>
   <option value="1"<?php if($info->status == 1){echo "selected";}?> >已审核</option>
</select>
<div class="clear"></div>
<?php }?>
</li>

<li>
<?php if($info->status != 0){?>
<label id="name">状态:</label>
<?php
                        switch($info->status){
                            case 0;
                            echo "未审核";
                        break;
                            case 1;
                            echo "已审核";
                        break;
                    }?>
<div class="clear"></div>
<?php }?>
</li>

<li>
<?php if($info->status !=0){?>
<label id="name">审核时间:</label>
<p id="add_time"><?php echo date('Y-m-d H:i:s',$info->update_time); ?></p>
<div class="clear"></div>
<?php }?>
</li>

  </ul>
   </dd>
    </dl>
   <div class="clear"></div>

  <p style="float:left; padding-left:10%;"></p>
  <?php if($info->status ==0){?>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" id="btn_next" value=" 重置 " /></p>
  <?php }?>
   </div>
  </div>
  </form>

