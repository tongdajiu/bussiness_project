<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <title>砸蛋活动</title>
    <style type="text/css">
    html,body{margin:0;padding:0;width:100%;height:100%;overflow:hidden;}
    .webpage{display:block; width:100%;min-height:100%; <?php if( $arrEggImg->background !=''){?>background-image:url("upfiles/lottery/turntable/<?php echo $arrEggImg->background;?>");<?php }?> background-size:cover; text-align:center;}
    .webpage .pbg-bg{width:100%;}
    .webpage .subject{text-align:center; padding-top:20px;}
    .webpage .subject .subimg{width:100%;}
    .ly-plate{display:block; width:100%;}
    .ly-plate .rotate-bg{display:block; width:100%; position:relative; /*background-image:url(""); background-size:100% 100%;*/}
    .ly-plate .rotate-bg .ly-plate-bg{width:100%;}
    .ly-plate .rotate-bg .lottery-star{position:absolute; width:44%; height:44%; top:28.3%; left:28.3%;}

    .egg{width:90%;margin:0 auto;}
    .egg ul li{z-index:999;list-style:none;}
    .eggList{padding:10% 0 0;position:relative;width:100%;overflow:hidden;}
    .eggList li{float:left;<?php if( $arrEggImg->turntable !=''){?>background:url("upfiles/lottery/turntable/<?php echo $arrEggImg->turntable;?>")<?php }?> no-repeat bottom;background-size:100% auto;width:28%;margin:2.5%;padding-bottom:39.4%;cursor:pointer;position:relative;}
    .eggList li span{position:absolute; width:100%;  left:0; top:50%; color:#ff0;font-size:42px; font-weight:bold;text-align:center;}
    .eggList li.curr{<?php if( $arrEggImg->pointer !=''){?>background:url("upfiles/lottery/turntable/<?php echo $arrEggImg->pointer;?>")<?php }?> no-repeat bottom;background-size:100% auto;cursor:default;z-index:300;}
    .eggList li.curr sup{position:absolute;<?php if( $arrEggImg->explain_image !=''){?>background:url("upfiles/lottery/turntable/<?php echo $arrEggImg->explain_image;?>")<?php }?> no-repeat;background-size:100% auto;width:120%;height:100%;top:0;left:0;z-index:800;}
    /*.resultTip{position:absolute; background:#ffc ;width:148px;padding:6px;z-index:500;top:200px;left:10px; color:#f60; text-align:center;overflow:hidden;display:none;z-index:500;}
    .resultTip b{font-size:14px;line-height:24px;}*/
    </style>
</head>
<body>
<?php include_once('loading.php');?>
<div class="webpage">
    <div class="subject"><?php if(  $arrEggImg->title_image !=''){?><img class="subimg" src="upfiles/lottery/turntable/<?php echo $arrEggImg->title_image;?>" /><?php }?></div>
    <div class="ly-plate">
        <div class="rotate-bg">
            <div class="egg">
                <ul class="eggList">
                    <li><span>1</span><sup></sup></li>
                    <li><span>2</span><sup></sup></li>
                    <li><span>3</span><sup></sup></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="res/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

function eggClick(obj)
{
    var _this = obj;
    $(".eggList li").unbind('click');
    _this.children("span").hide();
    _this.addClass('curr');
    _this.find("sup").show(); //金花四溅

    $.ajax({
        url:'egg.php?act=check',
        dataType:'json',
        success:function(data){
            alert(data.msg);
        }

    });
}

$(function(){
    $(".hammer").hide();//隐藏锤子
})

$(".eggList li").click(function() {
    eggClick($(this));
});
</script>
</body>
</html>