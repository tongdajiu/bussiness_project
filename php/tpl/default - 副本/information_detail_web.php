<?php include_once('common_header.php');?>
<link href="res/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="res/js/jquery.cycle.all.js"></script>
<?php include_once('loading.php');?>

<?php include "head_index.php";?>

<div class="index-wrapper">


    <div class="list02-pic-txt">
    	<p class="list02-pic-txt_01" style="text-align:center"><?php echo $obj->title?></p>
 		<p class="list02-pic-txt_02"><?php echo date("Y-m-d H:i:s",$obj->addtime);?></p>
    </div>

    <div class="list02-pic-intro">
    	<div class="list02-pic-intro-txt">
        	<p class="list02-pic-txt_01"><?php echo $obj->content?></p>
        </div>

        <!--<div class="list02-pic-intro-line">
        	<a href="#"><div class="list02-pic-intro-line01"><div class="list02-pic-intro-line01-txt">发送给朋友</div></div></a>
            <a href="#"><div class="list02-pic-intro-line02"><div class="list02-pic-intro-line02-txt">分享到朋友圈</div></div></a>
        </div>-->
    </div>



</div>
<?php include_once('common_footer.php');?>