var proAttrlist = null, myNowProAttr = '',maxProNum = 999;
var timeoutTimer;
$(function(){
	var skuItemHtml = new Object();
	$(".proSku.sku-item").each(function(index, el) {
		var idNum = $(el).find('dt').attr('data-id');
		skuItemHtml[idNum] = $(el).html();
		$(el).remove();
	});
	for(var sku1 in skuItemHtml){
		$(".proSku.proSku_quantity").before("<dl class='proSku sku-item'>"+skuItemHtml[sku1]+"</dl>");
	}

	$(".sku-item li").on("click",function(){
		var _this = $(this);
		var attrId, attrValId, attrVal;
		var nowProAttr = '';
		var optionalProAttr = new Array();

		//不可选择
		if(_this.hasClass("no")){
			return false;
		}
		$(".sku-item li").addClass("no");

		if(!!_this.hasClass("select")){		//取消选中属性值
			_this.removeClass("select");
		}else if(!_this.parents(".property_select").find("li").hasClass("select")){		//选择一个属性值
			_this.addClass("select");
		}else{		//选择这一属性其他属性值
			_this.siblings().removeClass("select");
			_this.addClass("select");
		}

		if($(".sku-item li.select").length > 0){
			//生成选中的属性组合
			$(".sku-item li.select").each(function(index, element){
				attrId = $(element).parents("dd").prev("dt").attr("data-id");
				attrValId = $(element).attr("data-aid");
				if(index != 0){
					nowProAttr += ':';
				}
				myNowProAttr = nowProAttr += attrId + '-' + attrValId;
			});
			nowProAttr = nowProAttr.split(':');

			//生成可以选择的属性值
			for(var item in proAttrlist){		//遍历 全部商品 属性组合
				var attrAry = item.split(':');

				var a = true;
				for(var nowProAttrItem in nowProAttr){		//遍历 选中的 商品属性组合数组
					if(attrAry.indexOf(nowProAttr[nowProAttrItem]) >= 0){
						a = a && true;
					}else{
						a = a && false;
					}
				}
				if(a){
					optionalProAttr.push(attrAry);
				}
			}

			//可选择的
			for(var optionalProAttrItem in optionalProAttr){
				for(var optionalProAttrItem2 in optionalProAttr[optionalProAttrItem]){
					var tmp_attrId = optionalProAttr[optionalProAttrItem][optionalProAttrItem2].split('-')[0];
					var tmp_attrValId = optionalProAttr[optionalProAttrItem][optionalProAttrItem2].split('-')[1];
					$(".sku-item").each(function(index, element){
						if($(element).find("dt").attr("data-id") == tmp_attrId){
							$(element).find("li").each(function(index_2,element_2){
								if($(element_2).attr("data-aid") == tmp_attrValId){
									$(element_2).removeClass("no");
								}
							});
						}
					});
				}
			}

		}else{
			$(".sku-item li").removeClass("no");
			myNowProAttr = '';
			$("#price_new").html($(".sku-new-price").attr("data-price"));
		}

		//未选择产品属性重置
		$(".quantity_txt").val(1);
		$("#price_new,#pro_oprice").html($(".sku-new-price").attr("data-price"));
		$("#pro_discount").addClass("hidden");
		$("#pro_oprice").parent().addClass("hidden");
		$("#active_timeOut").addClass("hidden");
		$("#store_menber").html($(".sku-new-price").attr("data-store"));
		rtime(0);
		maxProNum = $(".sku-new-price").attr("data-store");

		$(".outofstock").hide();
		$(".hasstock").show();
		$(".shoppingCart-table-R-number").val(1);
		// console.log(myNowProAttr)
		for(var proAttrlistItem in proAttrlist){
			if(myNowProAttr == proAttrlistItem){
				//库存
				$("#store_menber").html(proAttrlist[myNowProAttr]["store"]);
				//底部 购买/缺货 按钮
				if(proAttrlist[myNowProAttr]["store"] != 0){
					//价格
					$("#price_new").html(proAttrlist[myNowProAttr]["price"]);
					//原价
					$("#pro_oprice").parent().removeClass("hidden");
					$("#pro_oprice").html(proAttrlist[myNowProAttr]["oprice"]);
					//折扣
					$("#pro_discount").removeClass("hidden").html(proAttrlist[myNowProAttr]["discount"] + "折");
					//倒计时
					rtime(proAttrlist[myNowProAttr]["rtime"]);
				}
				//选择数量限制
				maxProNum = parseInt(proAttrlist[myNowProAttr]["store"]);
			}
		}

		if($("#store_menber").text() <= 0){
			$(".sku_buy a").show();
			$(".quantity,.sku_buy a.canChoose").hide();
		}else{
			$(".sku_buy a").hide();
			$(".quantity,.sku_buy a.canChoose").show();
		}

	});

})
function attrCheck(){
	var iffull = false;
	if(myNowProAttr == ''){
		return "请选择商品属性!";
	}else{
		for(var proAttrlistItem in proAttrlist){
			if(myNowProAttr == proAttrlistItem){
				iffull = true;
			}
		}
		if(!iffull){
			return "请选择完整的商品属性";
		}
	}
}
function rtime(time){
	clearTimeout(timeoutTimer);
	var price = $("#pro_oprice").text();
	atime = parseInt(time);
	if(atime<=0){
		$("#active_timeOut").show().html("优惠结束，价格已恢复"+price+"元");
		$("#price_new").text(price);
		$("#pro_oprice").parent().hide();
		$("#pro_discount").hide();
	}else{
		$("#pro_oprice").parent().show();
		$("#pro_discount").show();
		$("#active_timeOut").removeClass("hidden");
		var day = parseInt(time/60/60/24);		//天数
		time = time%(60*60*24);
		var hour = parseInt(time/60/60);		//时
		time = time%(60*60);
		var minute = parseInt(time/60);			//分
		var second = parseInt(time%60);			//秒

		$("#active_timeOut").show().html('剩<span>'+day+'</span>天<span>'+hour+'</span>小时<span>'+minute+'</span>分<span>'+second+'</span>秒，价格将恢复'+price+'元');
		timeoutTimer = setTimeout(function(){
			$("#active_timeOut").html('剩<span>'+day+'</span>天<span>'+hour+'</span>小时<span>'+minute+'</span>分<span>'+second+'</span>秒，价格将恢复'+price+'元');
			rtime(--atime);
		},1000);
	}

}









