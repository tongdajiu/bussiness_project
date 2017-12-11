<?php
    require_once 'wx_coupon_class.php';
    $wx = new WxApi();
    $result = $wx->
    //通过网页获取openid
    //if(!isset($_GET['code'])){
    //    header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=".WxApi::appId."&redirect_uri=http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
    //}
    //else{
    //    $CODE =  $_GET['code'];
    //    $Info = $wx->wxOauthAccessToken($CODE);
        //print_r($Info);
    //    $openId = $Info['openid'];
    //}
    ////////////////////////////////////////////

    $signPackage = $wx->wxJsapiPackage();
    //print_r($signPackage);
    $kqInfo = $wx->wxCardPackage("***************");
    $listInfo = $wx->wxCardListPackage();
?>
<html>
    <head>
        <title>JSAPI接口测试</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    </head>
    <body>
        <div>
            <input type="button" id="batchAddCard" name="batchAddCard" value="添加卡券" /><br />
            <input type="button" id="openCard" name="openCard" value="拉起卡券库" /><br />
            <input type="button" id="ShareTimeLine" name="ShareTimeLine" value="分享朋友圈" /><br />
            <div id="showInfo">

            </div>
        </div>

        <script>
            wx.config({
              debug: false,
              appId: '<?php echo $signPackage["appId"];?>',
              timestamp: <?php echo $signPackage["timestamp"];?>,
              nonceStr: '<?php echo $signPackage["nonceStr"];?>',
              signature: '<?php echo $signPackage["signature"];?>',
              jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'onMenuShareTimeline',
                  'onMenuShareAppMessage',
                  'addCard',
                  'openCard'
              ]
            });

            wx.ready(function () {
                // 在这里调用 API
                wx.onMenuShareAppMessage({
                    title: '互联网之子',
                    desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                    link: 'http://movie.douban.com/subject/25785114/',
                    imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                    trigger: function (res) {
                        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                        alert('用户点击发送给朋友');
                    },
                    success: function (res) {
                        alert('已分享');
                    },
                    cancel: function (res) {
                        alert('已取消');
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });

            document.querySelector('#ShareTimeLine').onclick = function () {
                wx.onMenuShareTimeline({
                        title: '互联网之子',
                        link: 'http://movie.douban.com/subject/25785114/',
                        imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                        trigger: function (res) {
                                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                                alert('用户点击分享到朋友圈');
                        },
                        success: function (res) {
                                alert('已分享');
                        },
                        cancel: function (res) {
                                alert('已取消');
                        },
                        fail: function (res) {
                                alert(JSON.stringify(res));
                        }
                });
            };

              document.querySelector('#batchAddCard').onclick = function () {
                wx.addCard({
                  cardList: [
                    {
                      cardId: '***************************',
                      cardExt: '{"timestamp":"<?php echo $kqInfo['cardExt']['timestamp'];?>", "signature":"<?php echo $kqInfo['cardExt']['signature'];?>"}'
                    }
                  ],
                  success: function (res) {
                    var cardList = res.cardList; // 添加的卡券列表信息
                    alert(cardList);
                  },
                cancel: function (res) {
                        alert('已取消');
                },
                fail: function (res) {
                        alert(JSON.stringify(res));
                }
                });
              };

              var shareData = {
                title: '微信JS-SDK Demo',
                desc: '微信JS-SDK,帮助第三方为用户提供更优质的移动web服务',
                link: 'http://demo.open.weixin.qq.com/jssdk/',
                imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
              };

              wx.onMenuShareAppMessage(shareData);

              wx.onMenuShareTimeline(shareData);
            });

            var readyFunc = function onBridgeReady() {
                // 绑定关注事件
                document.querySelector('#openCard').addEventListener('click',
                    function(e) {
                        WeixinJSBridge.invoke('chooseCard', {
                            "app_id": "<?php echo $listInfo['app_id']?>",
                            "location_id ": '',
                            "sign_type": "SHA1",
                            "card_sign": "<?php echo $listInfo['card_sign']?>",
                            "card_id": "<?php echo $listInfo['card_id']?>",
                            "card_type": "<?php echo $listInfo['card_type']?>",
                            "time_stamp": "<?php echo $listInfo['time_stamp']?>",
                            "nonce_str": "<?php echo $listInfo['nonce_str']?>"
                        },
                    function(res) {
                        alert(res.err_msg + res.choose_card_info);
                        $("#showInfo").empty().append(res.err_msg + res.choose_card_info);
                    });
                });
            }

            if (typeof WeixinJSBridge === "undefined") {
                document.addEventListener('WeixinJSBridgeReady', readyFunc, false);
            } else {
                readyFunc();
            }

          </script>
    </body>
</html>