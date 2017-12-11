<div class="content_title">抽奖活动信息列表管理</div>
<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../res/js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=lottery_action&act=add">添加活动</a>
</div>

<div class="search">
    <form action="index.php?module=lottery_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <select class="lottery_type" name="lottery_type">
                         <option value="0">全部</option>
                        <?php foreach( $ActivityType as $key=>$activity ){ ?>
                            <option value="<?php echo $key ?>"<?php echo $key==$lottery_type ? "SELECTED" : "" ?>><?php echo $activity ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="module" value="lottery_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

<form action="index.php" method="POST" name="myForm" >
    <input type="hidden" name="module" value="lottery_action">
    <input type="hidden" name="act" value="">
    <input type="hidden" name="lottery_id" value="">
    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
        <thead>
            <tr>
                <th><h3>序号</h3></th>
                <th><h3>活动ID</h3></th>
                <th><h3>主题</h3></th>
                <th><h3>活动类型</h3></th>
                <th><h3>活动开始时间</h3></th>
                <th><h3>活动结束时间</h3></th>
                <th><h3>活动开启状态</h3></th>
                <!-- <th><h3>活动抽奖次数</h3></th> -->
                <th><h3>操作</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php
            	$i=0;
           	 	foreach ($lotteryList['DataSet'] as $row) {
                	$i++;
            ?>

            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row->lottery_id;?></td>
                <td><?php echo $row->subject; ?></td>
                <td>
                <?php if($row->lottery_type !=0){?>
                	<?php echo $ActivityType[$row->lottery_type]; ?>
                <?php }?>
                </td>

                <td>
               		<?php  echo ($row->start_time !=0) ? date('Y-m-d H:s:m',$row->start_time) : '--' ;?>
                </td>

                <td>
                	<?php  echo ($row->end_time !=0) ? date('Y-m-d H:s:m',$row->end_time) : '--' ;?>
                </td>

                <td>
                    <?php
                    switch($row->status){
                        case 0;
                            echo "禁用";
                            break;
                        case 1;
                            echo "开启";
                            break;
                    }?>
                </td>
                <!-- <td><?php echo $row->number; ?></td> -->
                <td>
                    <a href="?module=lottery_action&act=edit&lottery_id=<?php echo $row->lottery_id; ?>" class="btn btn-green">编辑</a>
                	<a href="?module=lottery_setting_action&act=add&setting_id=<?php echo $row->lottery_id;?>" class="btn btn-blue">奖品设置</a>
                	<a href="?module=lottery_log_action&activity=<?php echo $row->lottery_id;?>" class="btn btn-orange">抽奖记录</a>
                	<a href="?module=lottery_action&act=del&lottery_id=<?php echo $row->lottery_id; ?>" onclick="javascript:return window.confirm('确定删除？');" class="btn btn-red">删除</a>
                   <?php if(VersionModel::isOpen('qrcodeGoodsUser')){?>
                     <a href="showQrcode.php?act=lottery&lottery_type=<?php echo $row->lottery_type;?>" class="highslide btn btn-orange" onclick="return hs.htmlExpand( this, {objectType: 'iframe', headingText: '活动二维码', width: 420, height: 420} )">查看二维码</a>
                <?php }?>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</form>
<div id="tablefooter">
	<div id="tablelocation">
	    <div>
	        <span class="STYLE1">共<?php echo $lotteryList['RecordCount']; ?>条纪录，当前第<?php echo $lotteryList['CurrentPage']; ?>/<?php echo $lotteryList['PageCount']; ?>页，每页<?php echo $lotteryList['PageSize']; ?>条纪录</span>
	        <a href="<?php echo $url . $lotteryList['First']; ?>">[第一页]</a>
	        <a href="<?php echo $url . $lotteryList['Prev']; ?>">[上一页]</a>
	        <a href="<?php echo $url . $lotteryList['Next']; ?>">[下一页]</a>
	        <a href="<?php echo $url . $lotteryList['Last']; ?>">[最后一页]</a>
	    </div>
	    <div class="page"></div>
	</div>
</div>
<script>
	$('#lottery_type').change(function(){
		$('form[name="myForm2"]').submit();
	})
</script>

</body>
</html>