<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <title><?php echo $site_name;?></title>
    <link href="res/css/common.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        body{margin:0; background-color:#281a74;}
        .webpage{display:block; width:100%; <?php if( $arrLotteryImg->background !='' ){?>background-image:url("/upfiles/lottery/turntable/<?php  echo $arrLotteryImg->background;?>");<?php }?> background-size:100% 100%; text-align:center;}
        .webpage .pbg-bg{width:100%;}
        .webpage .subject{text-align:center; padding-top:20px;}
        .webpage .subject .subimg{width:100%;}
        .ly-plate{display:block; width:100%;}
        .ly-plate .rotate-bg{display:block; width:100%; position:relative; <?php if( $arrLotteryImg->turntable !='' ){?>background-image:url("/upfiles/lottery/turntable/<?php echo $arrLotteryImg->turntable;?>");<?php }?> background-size:100% auto;background-repeat:no-repeat;background-position:center center;}
        .ly-plate .rotate-bg .ly-plate-bg{width:100%;}
        .ly-plate .rotate-bg .lottery-star{position:absolute; width:44%; height:44%; top:28.3%; left:28.3%;}
        .webpage .descinfo{margin-top:20px; margin-left:1.5%; width:97%;}
        .btntip{font-size:14px; text-align:center; margin:10px;}
        .btntip p{margin:8px;}
    </style>
    <script type="text/javascript" src="res/js/jquery-1.8.3.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="res/js/wxshare.js"></script>
    <script language="javascript">
        var wxcbs = {
            "shareAppMessage": {
                "success": "doShare"
            },
            "shareTimeline": {
                "success": "doShare"
            }
        };
//       wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>', wxcbs);
    </script>
</head>

<body>
<?php include_once('common_header.php');?>
<?php include_once('loading.php');?>
<div class="top_nav">
    <div class="top_nav_title">转盘抽奖</div>
    <a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>
    <div class="webpage">
        <div class="subject"><?php if( $arrLotteryImg->title_image !='' ){?><img class="subimg" src="/upfiles/lottery/turntable/<?php echo $arrLotteryImg->title_image;?>" /><?php }?></div>
        <div class="ly-plate">
            <div class="rotate-bg">
                <canvas class="ly-plate-bg" width="480px" height="480px"></canvas>
                <?php if( $arrLotteryImg->pointer !='' ){?>
                <img src="/upfiles/lottery/turntable/<?php echo $arrLotteryImg->pointer;?>" id="lotteryBtn" class="lottery-star">
                <?php }?>
            </div>
        </div>
       <div class="descinfo"><img style="max-width:100%;" src="/upfiles/lottery/turntable/<?php echo $arrLotteryImg->explain_image;?>" /></div>
    </div>

    <script type="text/javascript" src="res/utils/jQueryRotate/jQueryRotate.2.2.js"></script>
    <script type="text/javascript" src="res/utils/jQueryRotate/jquery.easing.min.js"></script>
    <script language="javascript">

        $(function(){
            $("#lotteryBtn").bind("click", function(){
				lottery()
            });
        });

        function doShare()
        {
            $.post("/lottery.php?act=2");
            alert("分享了");
        }

        function lottery()
        {
        	 $("#lotteryBtn").unbind("click");
            var startBtn = $("#lotteryBtn");
            startBtn.rotate({
                angle: 0,
                duration:3000,
                animateTo:3600,
                easing: $.easing.easeOutSine
            });
            $.ajax({
                type: 'POST',
                url: '/lottery.php?act=check',
                dataType: 'json',
                cache: false,
                data: {},
                error: function(){
                    alert("出错了");
                    startBtn.stopRotate();
                    return false;
                },
                success:function(json){
                    if(json.state == "1"){
                        var a = json.data.pos; //角度
                        startBtn.rotate({
                            duration:3000, //转动时间
                            animateTo:3600+a, //转动角度
                            easing: $.easing.easeOutSine,
                            callback: function(){
                                alert(json.msg);
                                startBtn.stopRotate();
                            }
                        });
                    }else{
                        alert(json.msg);
                        startBtn.stopRotate();
                    }
                }
            });
        }

    </script>
</body>
</html>