<style type="text/css">
	.regInfo ul{width:auto;}
	.ott_item{display:none;}
</style>

<div id="mainCol" class="clearfix">
	<div class="regInfo">
		<div class="content_title content_title_tab">
			<a href="javascript:;" class="active">系统设置</a>
			<a href="javascript:;">微信设置</a>
			<a href="javascript:;">其他设置</a>
		</div>
		<!--系统设置-->
		<div class="ott_item" style="display:block;">
		<form action="?module=setting" id="regform" class="form-horizontal" method="post"  role="form"  enctype="multipart/form-data">
			<dl class="ott" style="display:block;">
			<dd>
				<ul class="ottList">
					<li>
						<label class="labelName">站点名称:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[site_name]" class="regTxt"  value="<?php echo $data['site_name']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">站点地址:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[site_url]" class="regTxt"  value="<?php echo $data['site_url']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">站点描述:</label>
						<input type="text" name="data[site_desc]" class="regTxt"  value="<?php echo $data['site_desc']?>" />
						<div class="clear"></div>
					</li>

<!--					
					<li>
						<label class="labelName">模板设置：</label>
						<select name="data[template]" id="con-tpl">
							<?php foreach($templates as $tpl){ ?>
								<option value="<?php echo $tpl['flag'];?>"<?php echo $selTpl[$tpl['flag']];?>><?php echo $tpl['cfg']['name'];?></option>
							<?php } ?>
						</select>
					</li>
					<?php if(VersionModel::isOpen('setSkin')){ ?>
					<li>
						<label class="labelName">皮肤设置:</label>
						<select name="data[skin]" id="con-skin"></select>
						<div class="clear"></div>
					</li>
					<?php } ?>

					<li>
						<label class="labelName">分销各等级返利提成:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[distribution_rebate]" class="regTxt"  value="<?php echo $data['distribution_rebate']?>" />
						<p>（各等级返利百分比以“#”分隔，如 20#10#5，最多为3级）</p>
						<div class="clear"></div>
					</li>
-->					
					<li>
						<label class="labelName">联系方式:</label>
						<input type="text" name="data[contact]" class="regTxt"  value="<?php echo $data['contact']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">统计链接:</label>
						<input type="text" name="data[statistics_link]" class="regTxt"  value="<?php echo $data['statistics_link']?>" />
						<div class="clear"></div>
					</li>
				</ul>
			</dd>
			</dl>
			<p class="continue">
				<input type="submit" class="btn btn-big btn-blue" id="btn_next" value=" 确定 " />
				<input type="reset" class="btn btn-big" id="btn_next" value=" 重置 " />
			</p>
		</form>
		</div>
		<!--微信设置-->
		<div class="ott_item">
		<form action="?module=setting" id="regform2" class="form-horizontal" method="post"  role="form"  enctype="multipart/form-data">
			<dl class="ott">
			<dd>
				<ul class="ottList">
					<li>
						<label class="labelName">appid:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[appid]" class="regTxt"  value="<?php echo $data['appid']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">appsecret:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[appsecret]" class="regTxt"  value="<?php echo $data['appsecret']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">token:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[token]" class="regTxt"  value="<?php echo $data['token']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">encodingaeskey:</label>
						<input type="text" name="data[encodingaeskey]" class="regTxt"  value="<?php echo $data['encodingaeskey']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">微信支付商户号:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[wx_pay_mchid]" class="regTxt"  value="<?php echo $data['wx_pay_mchid']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">商户支付密钥:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[wx_pay_key]" class="regTxt"  value="<?php echo $data['wx_pay_key']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">微信支付授权目录:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[wx_pay_dir]" class="regTxt"  value="<?php echo $data['wx_pay_dir']?>" />
						<p>（以“/”结尾）</p>
						<div class="clear"></div>
					</li>
					<!--<li>
						<label class="labelName">logo:<font style="color:#f00;">*</font></label>
						<input type="text" name="data[logo]" class="regTxt"  value="<?php echo $data['logo']?>" />
						<div class="clear"></div>
					</li>-->

					<li>
						<label class="labelName">微信关注页面地址:</label>
						<input type="text" name="data[weixin_follow_link]" class="regTxt"  value="<?php echo $data['weixin_follow_link']?>" />
						<div class="clear"></div>
					</li>
				</ul>
			</dd>
			</dl>
			<p class="continue">
				<input type="submit" class="btn btn-big btn-blue" id="btn_next" value=" 确定 " />
				<input type="reset" class="btn btn-big" id="btn_next" value=" 重置 " />
			</p>
		</form>
		</div>
		<!--其他设置-->
		<div class="ott_item">
		<form action="?module=setting" id="regform3" class="form-horizontal" method="post"  role="form"  enctype="multipart/form-data">
			<dl class="ott">
			<dd>
				<ul class="ottList">
					<?php if(VersionModel::isOpen('setWaybill')){ ?>
					<li>
						<label class="labelName">物流接口:</label>
						<select name="data[logistics_interface]">
							<?php while(list($key,$val) = each($LogisticsInterface)){ ?>
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php } ?>
	                    </select>
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">物流身份授权id:</label>
						<input type="text" name="data[express_code_id]" class="regTxt"  value="<?php echo $data['express_code_id']?>" />
						<div class="clear"></div>
					</li>
					<?php } ?>
					<li>
						<label class="labelName">百度地图密钥:</label>
						<input type="text" name="data[baidu_map_keys]" class="regTxt"  value="<?php echo $data['baidu_map_keys']?>" />
						<div class="clear"></div>
					</li>
					<li>
						<label class="labelName">第三方客服链接:</label>
						<input type="text" name="data[service_third_url]" class="regTxt"  value="<?php echo $data['service_third_url']?>" />
						申请地址：<a target="_blank" href="http://www.meiqia.com">http://www.meiqia.com</a>
						<div class="clear"></div>
					</li>
				</ul>
			</dd>
			</dl>
			<p class="continue">
				<input type="submit" class="btn btn-big btn-blue" id="btn_next" value=" 确定 " />
				<input type="reset" class="btn btn-big" id="btn_next" value=" 重置 " />
			</p>
		</form>
		</div>

	</div>
</div>

<script language="javascript">
var tplList = <?php echo json_encode($templates);?>;
$(function(){
	jQuery.validator.addMethod("telphone", function(value, element) {
	    var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$|(^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$)/;
	    return this.optional(element) || (tel.test(value));
	}, "请填写正确的联系方式.");
	jQuery.validator.addMethod("rebate", function(value, element) {
	    var tel = /^(0|[1-9][0-9]?|100)((#(0|[1-9][0-9]?|100)){0,2})$/;
	    return this.optional(element) || (tel.test(value));
	}, "格式错误.");

	$("#regform").validate({
        rules: {
		   "data[site_name]": {
			   required: true
		   },
		   "data[site_url]": {
			   required: true
		   },
		   "data[distribution_rebate]": {
			   required: true,
			   rebate: true
		   },
		   "data[contact]": {
			   telphone: true
		   },
		   "data[statistics_link]": {
			   url: true
		   }
  		},
  		submitHandler:function(form){
  			confirm('提交后不能撤销，确定提交吗?') ? form.submit() : "";
  		}
    });
    $("#regform2").validate({
        rules: {
		   "data[appid]": {
			   required: true
		   },
		   "data[appsecret]": {
			   required: true
		   },
		   "data[token]": {
			   required: true
		   },
		   "data[wx_pay_mchid]": {
			   required: true
		   },
		   "data[wx_pay_key]": {
			   required: true
		   },
		   "data[wx_pay_dir]": {
			   required: true
		   },
		   "data[weixin_follow_link]": {
			   url: true
		   }
  		},
  		submitHandler:function(form){
  			confirm('提交后不能撤销，确定提交吗?') ? form.submit() : "";
  		}
    });
    $("#regform3").validate({
        rules: {
		   "data[logistics_interface]": {
			   required: true
		   },
		   "data[express_code_id]": {
			   required: true
		   },
		   "data[baidu_map_keys]": {
			   required: true
		   }
  		},
  		submitHandler:function(form){
  			confirm('提交后不能撤销，确定提交吗?') ? form.submit() : "";
  		}
    });

	//tab
    $(".content_title a").click(function(){
    	var index = $(".content_title a").index(this);
    	$(".content_title a").removeClass("active").eq(index).addClass("active");
		$(".ott_item").hide().eq(index).show();
    });

	<?php if(VersionModel::isOpen('setSkin')){ ?>
	triggerSkin("<?php echo $data['skin'];?>");
	$("#con-tpl").on("change", function(){
		triggerSkin("");
	});
	<?php } ?>
});

<?php if(VersionModel::isOpen('setSkin')){ ?>
function triggerSkin(def){
	var tpl = $("#con-tpl").find("option:selected").val();
	var skins = tplList[tpl]['skin'];
	console.log(skins);
	var conSkin = $("#con-skin");
	var strOpt = "";
	for(var i in skins){
		strOpt += '<option value="'+skins[i]["flag"]+'"'+((def == skins[i]["flag"]) ? " selected" : "")+'>'+skins[i]["cfg"]["name"]+'</option>';
	}
	conSkin.html(strOpt);
}
<?php } ?>
</script>