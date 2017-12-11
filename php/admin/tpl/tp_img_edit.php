<script src="../res/js/jquery.autocomplete.js" type="text/javascript"></script>
<link href="../res/css/jquery.autocomplete.css" type="text/css" rel="stylesheet"/>
<script src="../res/js/jquery.chained.min.js"></script>
<form action="?module=tp_img" id="regform" class="cmxform" method="post" enctype="multipart/form-data">

<input type="hidden" name="act" value="edit_save">
<input type="hidden" name="id" value="<?php echo $obj->id;?>">
<input type="hidden" name="site" value="<?php echo $site;?>">
<input type="hidden" name='from' value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>">
<div id="mainCol" class="clearfix">
<div class="regInfo">
<div class="content_title">编辑</div>
 <dl class="ott">
<dd>
<ul class="ottList">

<!--
<li>
<label class="labelName">选择分类<font style="color:#f00;">*</font></label>
<select name="type" id="type" class="srchField selectField">
<?php
foreach($classify as $tlist) {
					$xsel = $obj->type == $tlist->id ? ' selected' : '';
?>
<option value="<?php echo $tlist->id;?>" <?php echo $xsel;?>>
<?php echo $tlist->name;?>
</option>
<?php
}
?>
</select>
<div class="clear"></div>
</li>
-->

<?php if ( $from != 'subscribe' ){ ?>
	<li>
		<label class="labelName">关键词: <font style="color:#f00;">*</font></label>（注：subscribe为关键词，不给予设置）
		<input type="text" id="keyword" value="<?php echo $obj->keyword; ?>" name="keyword" class="regTxt" />
		<div class="clear"></div>
	</li>
<?php } ?>

<li>
	<label class="labelName">标题：<font style="color:#f00;">*</font></label>
	<input type="text" id="title" value="<?php echo $obj->title; ?>" name="title" class="regTxt" />
	<div class="clear"></div>
</li>


<li>
	<label class="labelName">简介:<font style="color:#f00;">*</font></label>
	<div style="margin-left:212px;" >
		<textarea style="width:350px;height:120px; font-size:14px; padding:5px;" name="text"><?php echo $obj->text?></textarea>
	</div>
	<div class="clear"></div>
</li>

<li>
	<label class="labelName">封面图片: <font style="color:#f00;">*</font></label>
	&nbsp;
			<?php if($obj->pic!=''){ ?>
			<img src="<?php echo $obj->pic;?>" width="150" border="0" />
			<?php }?>
			<input type="file" name="pic" class="fileField" />
	    </td>
	<div class="clear"></div>
</li>


	<li>
		<label class="labelName">图文详细内容:<font style="color:#f00;">*</font></label>
		<div style="margin-left:212px;" >
			<script id="editor" type="text/plain" style="width:500px;height:240px;"><?php echo $obj->info?></script>
		</div>
		<input type="hidden" name="info" value="" id="info" />
		<div class="clear"></div>
	</li>

<li>
<label class="labelName">图文外链地址:<font style="color:#f00;">*</font></label>
<input type="text" id="url" value="<?php echo $obj->url; ?>" name="url" class="regTxt" />

<div class="clear"></div>
<p style="margin-left: 212px;font-size:12px;color:red;">如需跳转到其他网址，请在这里填写网址 (例如：http://baidu.com，记住必须有http://) 如果填写了图文详细内容，这里请留空，不要设置！</p>
</li>


  </ul>
   </dd>
    </dl>
   <div class="clear"></div>

  <p style="float:left; padding-left:10%;"></p>
  <p class="continue"><input type="submit" class="continue" id="btn_next" value=" 确定 " /><input type="reset" class="continue" value=" 重置 " /></p>
   </div>
  </div>
  </form>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo __UTILS__;?>/umeditor/ueditor.all.min.js"> </script>
<script language="javascript">
	var ue = UE.getEditor('editor');
	window.onload=function(){
		var btn_next=document.getElementById("btn_next");
		var mycontent=document.getElementById("info");
		btn_next.onclick=function(){
			mycontent.value=ue.getContent();
			return true;
		}
	}
</script>
<script type="text/javascript">
    $().ready(function(){
		$("#btn_next").click(function(){
			if(UM.getEditor('myEditor1').getContent() == ""){
				if($("#myEditor1").parents(".edui-container").parent().find("label.error").length == 0){
					$("#myEditor1").parents(".edui-container").parent().append("<label for=\"\" class=\"error\">不能为空.</label>");
				}
				return false;
			}else{
				regform.info.value=UM.getEditor('myEditor1').getContent();
				$("#myEditor1").parents(".edui-container").next("label.error").remove();
				return true;
			}
		});

		$("#regform").validate({
	        rules: {
			   "keyword": {
				   required: true
			   },
			   "title": {
				   required: true
			   },
			   "text": {
				   required: true,
			   },
			   "url": {
				   url: true
			   }
	  		}
	    });
    });
</script>