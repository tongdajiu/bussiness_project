<div class="content_title">管理员组</div>

<div class="regInfo">
	<dl class="ott">
		<dd>
			<form action="?module=admin_group_action" id="regform"  method="post">
				<input type="hidden" value="edit_save" name="act" />
				<input type="hidden" value="<?php echo $arrData->id; ?>" name="id" />
				<ul class="ottList">
					<li>
						<label class="labelName" for="title">用户组:<font style="color:#f00;">*</font></label>
						<input type="text" id="title" value="<?php echo $arrData->title; ?>" name="title" class="regTxt" />
						<div class="clear"></div>
					</li>

					<li>
						<label class="labelName" for="description">描述:<font style="color:#f00;">*</font></label>
						<input type="text" id="description" value="<?php echo $arrData->description; ?>" name="description" class="regTxt" />
						<div class="clear"></div>
					</li>

					<li>
						<label class="labelName" for="status">状态:<font style="color:#f00;">*</font></label>
						<select name='status'>
							<option value='1' <?php echo $arrData->status==1 ? 'SELECTED' : ''; ?>>开启</option>
							<option value='0' <?php echo $arrData->status==0 ? 'SELECTED' : ''; ?>>禁用</option>
						</select>
						<div class="clear"></div>
					</li>

					<?php foreach( $arrInfos as $arrInfo ){ ?>
						<li class="checkbox_group">
							<label class="labelName"><input type="checkbox" name="rules[]" value="<?php echo $arrInfo->id; ?>" <?php echo in_array($arrInfo->id,$arrRules) ? 'CHECKED' : ''; ?> /><?php echo $arrInfo->name; ?></label>
							<dl class="c_g_content">
								<?php if( $arrInfo->child != null ) { ?>
								  <?php foreach( $arrInfo->child as $ChildList ) { ?>
									  <dt><label><input type="checkbox" name="rules[]" value="<?php echo $ChildList->id; ?>" <?php echo in_array($ChildList->id,$arrRules) ? 'CHECKED' : ''; ?> /><?php echo $ChildList->name; ?></label></dt>
									  <?php if( $arrInfo->child != null ) { ?>
										  <dd>
								     		<?php foreach( $ChildList->child as $SubChild ) { ?>
									     		<label><input type="checkbox" name='rules[]' value="<?php echo $SubChild->id; ?>" <?php echo in_array($SubChild->id,$arrRules) ? 'CHECKED' : ''; ?> /><?php echo $SubChild->name; ?></label>
									     	<?php } ?>
										  </dd>
									  <?php } ?>
								  <?php } ?>
								<?php } ?>
							</dl>
							<div class="clear"></div>
						</li>
					<?php } ?>					
				</ul>
				<p class="continue">
					<input type="submit" value="提 交 ">
					<input type="reset" value="重 置">
				</p>
			</form>
		</dd>
	</dl>
</div>


<script>
	$(function(){
		/*
		$(".checkbox_group").each(function(index, el) {
			var checkbox = $(el).find("label.labelName input:checkbox");
			if(checkbox.is(":checked")){
				checkbox.parents(".checkbox_group").find("input:checkbox").prop("checked",true);
			}
		});
		
		$(".c_g_content dt").each(function(index, el) {
			var checkbox = $(el).find("label input:checkbox");
			if(checkbox.is(":checked")){
				checkbox.parents(".c_g_content dt").next("dd").find("input:checkbox").prop("checked",true);
			}
		});
		*/
		
		$(".checkbox_group>label>input:checkbox").change(function(){
			$(this).parents(".checkbox_group").find("input:checkbox").prop("checked",$(this).is(":checked"));
		});
		$(".c_g_content dt>label>input:checkbox").change(function(){
			$(this).parents(".c_g_content dt").next("dd").find("input:checkbox").prop("checked",$(this).is(":checked"));
		});
		
		$(".c_g_content dd input:checkbox").change(function(){
			var isAllChecked = true;
			var _this = $(this);
			_this.parents(".c_g_content dd").find("input:checkbox").each(function(index, el) {
				if(!$(el).prop("checked")){
					$(el).parents(".c_g_content dd").prev().find("input:checkbox").prop("checked",false);
					isAllChecked = false;
				}
			});
			if(isAllChecked){
				_this.parents(".c_g_content dd").prev().find("input:checkbox").prop("checked",true);
			}
		});
		
		$(".c_g_content input:checkbox").change(function(){
			var isAllChecked = true;
			var _this = $(this);
			$(".c_g_content input:checkbox").each(function(index, el) {
				console.log(1)
				if(!$(el).prop("checked")){
					$(el).parents(".c_g_content").prev().find("input:checkbox").prop("checked",false);
					isAllChecked = false;
				}
			});
			if(isAllChecked){
				_this.parents(".c_g_content").prev().find("input:checkbox").prop("checked",true);
			}
		});
	})
</script>