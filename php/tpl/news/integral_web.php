<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.js"></script>
<script>
    var tabId = '',
        type = '1';
    var loaded = false,     //是否加载
        index = 0,          //当前页
        page = 1;           //下一页
    $(function() {
        $(".integral-table").each(function(index, el) {
            $(el).attr({
                "data-page": 1,
                "data-index": 0
            });
        });
        var pageCount = 0;      //总页数
        tab($("#tabs ul li:eq(0) a"));
    });

    function tab(obj){
        tabId = $(obj).attr("href");
        $(".integral-table").hide();
        $(tabId).show();
        $("#tabs ul li").removeClass("ui-tabs-active");
        $(obj).parent().addClass("ui-tabs-active");
        loaded = false;
        type = $(tabId).attr("data-type");
    }

    function show(id) {
        var wHeight = parseInt($(window).height());
        var dHeight = parseInt($(document).height());
        var tScroll = parseInt($(document).scrollTop());
        pageCount = $(id).attr("data-pageCount");
        index = $(id).attr("data-index");
        page = $(id).attr("data-page");
        if (!loaded && (tScroll >= dHeight-wHeight) && pageCount > 0 && pageCount>index) {
            $("#progressIndicator").show();
            index++;
            page++;
            $(id).attr({
                "data-index": index,
                "data-page": page
            });
            if (index >= pageCount) loaded = true;
            $.get("ajaxtpl/ajax_integral.php?page="+page+"&type="+type,
            function(data) {
                $(tabId).find("tbody").append(data);
                $("#progressIndicator").hide();
            })
        }
    };

    $(window).scroll(function(){
        show(tabId);
    });
</script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">积分管理</div>
	<a class="top_nav_left top_nav_back" href="user.php" title="返回"></a>
</div>

<div class="index-wrapper">

	<div class="integral_now_box">
		当前积分：
		<p class="integral_now"><span><?php echo $obj->integral;?></span>分</p>
	</div>

    <div class="clear"></div>

    <div class="integral-wrapper">
    	<div class="integral-Record" id="tabs">
        	<ul>
                <li><a href="#tabs-1" onclick="tab(this)">所有记录</a></li>
                <li><a href="#tabs-2" onclick="tab(this)">获取记录</a></li>
                <li><a href="#tabs-3" onclick="tab(this)">消费记录</a></li>
            </ul>
        	<div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1" data-pageCount="<?php echo $pager_all['PageCount']-1;?>" data-type="1">
            <?php if(count($pager_all['DataSet'])==0){ ?>
                <tr><td class="tips-null">暂无记录</td></tr>
            <?php }else{ ?>
                <tr>
                    <td class="integral-title">时 间</td>
                    <td class="integral-title">类 型</td>
                    <td class="integral-title">积 分</td>
                </tr>
            <?php foreach ($pager_all['DataSet'] as $row) { ?>
                <tr>
                    <td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
                    <td class="integral-txt" ><?php if($row->color=="1"){echo $IntegralPayType[$row->type];}else{echo $IntegralType[$row->type];}?></td>
                    <td class="integral-txt"><font color="<?php if($row->color=="1"){echo "#f60";}else{echo "#666";}?>"><?php echo intval($row->integral);?></font></td>
                </tr>
            <?php }} ?>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-2" data-pageCount="<?php echo $pager_records['PageCount']-1;?>" data-type="2">
            <?php if(count($pager_all['DataSet'])==0){ ?>
                <tr><td class="tips-null">暂无获取记录</td></tr>
            <?php }else{ ?>
                <tr>
                    <td class="integral-title">时 间</td>
                    <td class="integral-title">类 型</td>
                    <td class="integral-title">积 分</td>
                </tr>
            <?php foreach ($pager_records['DataSet']  as $row) { ?>
                <tr>
                    <td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
                     <td class="integral-txt"><?php echo $IntegralType[$row->type];?></td>
                    <td class="integral-txt"><font color="#f60">+<?php echo intval($row->integral);?></font></td>
                </tr>
            <?php }} ?>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-3" data-pageCount="<?php echo $pager_pay['PageCount']-1;?>" data-type="3">
            <?php if(count($pager_pay['DataSet'])==0){ ?>
                <tr><td class="tips-null">暂无消费记录</td></tr>
            <?php }else{ ?>
                <tr>
                    <td class="integral-title">时 间</td>
                    <td class="integral-title">类 型</td>
                    <td class="integral-title">积 分</td>
                </tr>
            <?php foreach ($pager_pay['DataSet'] as $row) { ?>
                <tr>
                    <td class="integral-txt"><?php echo date("Y-m-d",$row->addtime);?></td>
                    <td class="integral-txt"><?php echo $IntegralPayType[$row->type];?></td>
                    <td class="integral-txt"><font color="#f60">-<?php echo intval($row->integral);?></font></td>
                </tr>
            <?php }} ?>
            </table>
        </div>
    </div>
</div>

<?php include_once('common_footer.php');?>
