<?php include_once('common_header.php');?>
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<script>
    $(function() {
        var loaded = false,     //是否加载
            index = 0,          //当前页
            page = 1;           //下一页
        var pageCount = <?php echo $recordsList['PageCount'];?>;      //总页数

        function show() {
            var wHeight = parseInt($(window).height());
            var dHeight = parseInt($(document).height());
            var tScroll = parseInt($(document).scrollTop());
            if (!loaded && (tScroll >= dHeight-wHeight) && pageCount-1 > 0) {
                $("#progressIndicator").show();
                index++;
                page++;
                if (index >= pageCount-1) loaded = true;
                $.get("ajaxtpl/ajax_pay_records.php?page="+page,
                function(data) {
                    $(".integral-Record table").append(data);
                    $("#progressIndicator").hide()
                })
            }
        };

        $(window).scroll(show);
    });

</script>

<?php include_once('loading.php');?>
<div class="top_nav">
	<div class="top_nav_title">消费记录</div>
	<a class="top_nav_left top_nav_back" href="javascript:window.history.back(-1);" title="返回"></a>
</div>

<div class="clear"></div>

<div class="integral-wrapper">
    <?php if(count($recordsList['DataSet']) == 0){ ?>
        <div class="tips-null">暂无消费记录！</div>
    <?php }else{ ?>
	<div class="integral-Record" id="tabs">
    	<div class="clear"></div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="integral-table" id="tabs-1">
            <tr>
                <td class="integral-title"> 订单号</td>
                <td class="integral-title" width="30%">金额</td>
                <td class="integral-title">时间</td>
            </tr>

		<?php
		foreach ($recordsList['DataSet'] as $row) {
		?>
            <tr>
                <td class="integral-txt"><?php echo $row->order_num;?></td>
              <!-- 	<td class="integral-txt"><?php echo $row->type?></td>-->
               	<td class="integral-txt" ><?php echo "￥ ".number_format($row->money,2);?></td>
                <td class="integral-txt" ><?php echo date("Y-m-d H:i:s",$row->addtime);?></td>
            </tr>
         <?php }?>
        </table>
    </div>
    <div id="progressIndicator">
        <img width="85" height="85" src="res/images/ajax-loader-85.gif" alt=""> <span id="scrollStats"></span>
    </div>
    <?php } ?>
</div>

<?php include TEMPLATE_DIR.'/footer_web.php';?>
<?php include_once('common_footer.php');?>
