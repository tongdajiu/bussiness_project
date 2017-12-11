<div class="content_title">XXX</div>

<div class="regInfo">
	<dl class="ott">
		<dd>
			<form action="?module=admin_group_action" id="regform"  method="post">
				<ul class="ottList">

					<li class="checkbox_group">
						<label class="labelName" for="title">XXX:<font style="color:#f00;">*</font></label>
						<dl class="c_g_content" style="width:100%;">
							<dt><label><input type="checkbox" name="" value="" />全选</label></dt>
							<dd>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
								<label><input type="checkbox" name='' value=""  />XXXX</label>
							</dd>
						</dl>
						<div class="clear"></div>
					</li>

					<li>
						<label class="labelName" for="title">XXX:<font style="color:#f00;">*</font></label>
						<input type="text" value="" name="" class="regTxt" />
						<div class="clear"></div>
					</li>
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