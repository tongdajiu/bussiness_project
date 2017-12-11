<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head runat="server">
        <title><?php echo $site_name?></title>
        <link href="css/StyleSheet.css" rel="stylesheet" type="text/css" />
        <link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
        <!-- <base target="_self" /> -->
    </head>

    <body>
        <form id="form1" runat="server">
            <div id="header">
                <a href="index.php" class="logo"><h1><?php echo $site_name;?>后台管理</h1></a>
                <div class="header_r">
                    <h3>欢迎，<br/><?php echo isset($obj->name) ? $obj->name : '';?></h3>
                    <ul>
                        <li><a target="main" href="index.php?module=user_update_pass">修改密码</a></li>
                        <li><a onclick="if (!window.confirm('您确认要注消当前登录用户吗？')){return false;}" href="login.php?action=logout">注销</a></li>
                    </ul>
                </div>
                <a href="showQrcode.php" class="highslide header_r_qt" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '前台首页二维码', width: 360, height: 400} )" target="_blank">前台首页</a>
            </div>
            <div id="west">
                <div class="nano">
                    <div class="nano-content">
                        <dl></dl>
                    </div>
                </div>
            </div>
            <div id="west_content"><iframe name="main" id="west_main" src="index.php?module=home" frameborder="0"></iframe></div>
        </form>
        <script type="text/javascript" src="../res/js/jquery.1.10.2.min.js"></script>
        <script type="text/javascript" src="../res/js/jquery.nanoscroller.min.js"></script>
        <script>
        $(function(){
            $(".header_r").hover(function(){
                $(".header_r ul").stop().slideDown("fast");
            },function(){
                $(".header_r ul").stop().slideUp("fast");
            });

            (function(){
                var menu = [<?php echo $trees;?>];
                for(var i=0; i<menu.length; i++){
                    $("#west dl").append("<dt><div class='menuItem"+ i +"'>" + menu[i]["title"] + "</div></dt>");
                    $("#west dl").append("<dd>" + menu[i]["html"] + "</dd>");
                }
                $('.nano').nanoScroller({
                    preventPageScrolling: true
                });
                setTimeout(function(){
                    $("#loading-mask,#loading").fadeOut();
                },200);
            })();

            $(document).delegate("#west dd ul li a","click",function(){
                $("#west dd ul li a,#west dt").removeClass("active");
                $(this).addClass("active");
                $(this).parents("dd").prev("dt").addClass("active");
            });

            $(document).delegate("#west dt","click",function(){
                if($(this).next().is(":hidden")){
                    $(this).next("dd").stop().slideDown("fast",function(){
                        $('.nano').nanoScroller({
                            preventPageScrolling: true
                        });
                    });
                }else{
                    $(this).next("dd").stop().slideUp("fast",function(){
                        $('.nano').nanoScroller({
                            preventPageScrolling: true
                        });
                    });
                }
            });

        })
        </script>
        <script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
        <script type="text/javascript">
            hs.showCredits = 0;
            hs.padToMinWidth = true;
            hs.preserveContent = false;
            hs.graphicsDir = '../res/js/highslide/graphics/';
            hs.outlineType = 'rounded-white';
            hs.wrapperClassName = 'draggable-header';
            hs.align = 'center';
        </script>
    </body>
</html>