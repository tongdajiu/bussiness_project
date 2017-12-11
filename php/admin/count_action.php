<?php
!defined('HN1') && exit ('Access Denied.');
define('SCRIPT_ROOT', dirname(__FILE__) . '/');
require_once MODEL_DIR . '/UserModel.class.php';
require_once MODEL_DIR . '/OrderModel.class.php';

$act 		= !isset ($_REQUEST['act']) 		? "list" : $_REQUEST['act'];
$day        = !isset ($_REQUEST['day'])         ? "" : $_REQUEST['day'];
$start_time = !isset($_REQUEST['starttime'])  || $_REQUEST['starttime'] == '开始时间' ? '' : sqlUpdateFilter($_REQUEST['starttime']);
$end_time = !isset($_REQUEST['endtime'])  || $_REQUEST['endtime'] == '结束时间' ? '' : sqlUpdateFilter($_REQUEST['endtime']);
if($start_time != '' && $end_time != '')
{
    $starttime = strtotime($start_time.' 00:00:00');
    $endtime = strtotime($end_time.' 23:59:59'	);
}
else if($start_time != '' && $end_time == '' )
{
    $starttime = strtotime($start_time.' 00:00:00');
    $endtime = $starttime+30*24*60*60;
}else if($start_time == '' && $end_time != '' ) {

    $endtime = strtotime($end_time.' 00:00:00');
    $starttime = $endtime-30*24*60*60;

}else if($start_time == '' && $end_time == '' ) {

    $starttime = time();
    $endtime = $starttime+30*24*60*60;

}
function getNums($startTime,$endTime,$db,$obj){
    $Obj = new Model($db, $obj);
    $Cond = array();
    $Cond[] = 'addTime>='.$startTime;
    $Cond[] = 'addTime<='.$endTime;
    //$Info = $Obj->getCount(implode(' AND ', $Cond));
    $Info = $Obj->getAll(implode(' AND ', $Cond),$order=array(), $output = OBJECT, $limit='',$fields='addTime',$paramTable='');
    return $Info;
}
function getDay($selTime,$db,$obj){

    $arr = array();
    $st_time = strtotime(sqlUpdateFilter(date("Y-m-d",$selTime)).'00:00:00');
    $en_time = strtotime(sqlUpdateFilter(date("Y-m-d",$selTime)).'23:59:59');
    $Info = getNums($st_time,$en_time,$db,$obj);
    for($i=0;$i<24;$i++){
        $day_s = strtotime(sqlUpdateFilter(date("Y-m-d",$selTime)).$i.':00:00');
        $day_e = strtotime(sqlUpdateFilter(date("Y-m-d",$selTime)).($i).':59:59');
        //$day = getNums($day_s,$day_e,$db,$obj);
        $num = 0;
        foreach($Info as $k=>$v){
            if($v->addTime >= $day_s && $v->addTime <= $day_e){
                $num++;
            }
        }
        $arr[] = $num;
    }
    return $arr;
}
define('nowmodule', "count_action");
define('nowmodule_', "count");

$url = "?module=" . nowmodule;


switch ($act) {
    case 'user_count' :
        countNums($starttime,$endtime,$db,'user',$day);
        break;
    case 'order_count' :
        countNums($starttime,$endtime,$db,'orders',$day);
        break;
    default :
        break;
}
function countNums($starttime,$endtime,$db,$obj,$day){
    switch($obj){
        case 'user':
            $title = "新注册会员统计";
            $act = 'user_count';
            break;
        case 'orders':
            $title = "订单数统计";
            $act = 'order_count';
            break;
        default:
            break;
    }
    switch($day){
        case 'today':
            $selTime = time();

            $arr = getDay($selTime,$db,$obj);

            $arr = implode(',',$arr);
            $info= <<<json
<script>
var arr = '$arr';
var dataInfo = arr.split(",");
var dataName = new Array();
for(var i=0;i<dataInfo.length;i++){
 dataName[i] = i+'：00';
}
</script>
json;
            $title .= date("(Y年m月d日)",time());
            break;
        case 'yesterday':
            $selTime = strtotime("-1 day");
            $arr = getDay($selTime,$db,$obj);
            $arr = implode(',',$arr);
            $info= <<<json
<script>
var arr = '$arr';
var dataInfo = arr.split(",");
var dataName = new Array();
for(var i=0;i<dataInfo.length;i++){
 dataName[i] = i+'：00';
}
</script>
json;
            $title .= date("(Y年m月d日)",$selTime);
            break;
        case 'sevenDay':
            $arr = array();
            $dayArr = array();
            $eDay = sqlUpdateFilter(date("Y-m-d",strtotime("-1 day")));
            $enSevenDay = strtotime($eDay.' 00:00:00');
            $sDay = sqlUpdateFilter(date("Y-m-d",strtotime("-7 day")));
            $stSevenDay = strtotime($sDay.' 00:00:00');
            $Info = getNums($stSevenDay,$enSevenDay,$db,$obj);

            for($i=1;$i<=7;$i++){
                $theDay = sqlUpdateFilter(date("Y-m-d",strtotime("-$i day")));
                $sevenDay_s = strtotime($theDay.' 00:00:00');
                $sevenDay_e = strtotime($theDay.' 23:59:59');
                $num = 0;
                foreach($Info as $k=>$v){
                    if($v->addTime >= $sevenDay_s  && $v->addTime <= $sevenDay_e){
                       $num++;
                    }
                }
                $arr[] = $num;
                $dayArr[] = $theDay;
            }
            $title .= date("(Y年m月d日-",strtotime("-7 day")).date("Y年m月d日)",strtotime("-1 day"));
            $arr = implode(',',array_reverse($arr));
            $dayArr = implode(',',array_reverse($dayArr));
            $info= <<<json
<script>
var arr = '$arr';
var dayArr = '$dayArr';
var dataInfo= arr.split(",");
var dataName = dayArr.split(",");
</script>
json;

            break;
        case 'others':
            $dayCount = ceil(($endtime-$starttime)/(24*60*60));
            $arr = array();
            $brr = array();
            $title .= date("(Y年m月d日-",$starttime).date("Y年m月d日)",$endtime);
            $Info = getNums($starttime,$endtime,$db,$obj);
            for($i=0;$i<$dayCount;$i++){
                $theDay = date("Y-m-d",$starttime);
                $nestTime = $starttime + (24*60*59);
                //$selDay = getNums($starttime,$nestTime,$db,$obj);
                $num = 0;
                foreach($Info as $k=>$v){
                    if($v->addTime >= $starttime && $v->addTime <= $nestTime){
                        $num++;
                    }
                }
                $arr[] = $num;
                $brr[] = $theDay;
                $starttime = $starttime+24*60*60;
            }
            $arr = implode(',',$arr);
            $brr = implode(',',$brr);
            $info= <<<json
<script>
var arr = '$arr';
var brr = '$brr';
var dataInfo = arr.split(",");
var dataName = brr.split(",");
</script>
json;
            break;
        default:
            /*
            $today_s = strtotime(sqlUpdateFilter(date("Y-m-d",time())).' 00:00:00');
            $today_e = strtotime(sqlUpdateFilter(date("Y-m-d",time())).' 23:59:59');
            $today = getNums($today_s,$today_e,$db,$obj);


            $yesterday_s = strtotime(sqlUpdateFilter(date("Y-m-d",strtotime("-1 day"))).' 00:00:00');
            $yesterday_e = strtotime(sqlUpdateFilter(date("Y-m-d",strtotime("-1 day"))).' 23:59:59');
            $yesterday = getNums($yesterday_s,$yesterday_e,$db,$obj);

            $sevenDay_s = strtotime(sqlUpdateFilter(date("Y-m-d",strtotime("-1 week"))).' 00:00:00');
            $sevenDay_e = strtotime(sqlUpdateFilter(date("Y-m-d",strtotime("-1 day"))).' 23:59:59');
            $sevenDay = getNums($sevenDay_s,$sevenDay_e,$db,$obj);

            $selDay = getNums($starttime,$endtime,$db,$obj);

            $dataSet->addPoint(new Point("今天", $today));
            $dataSet->addPoint(new Point("昨天", $yesterday));
            $dataSet->addPoint(new Point("前7天", $sevenDay));
            $dataSet->addPoint(new Point("指定的时间", $selDay));
*/
            $selTime = time();
            $arr = getDay($selTime,$db,$obj);
            $arr = implode(',',$arr);
            $info= <<<json
<script>
var arr = '$arr';
var dataInfo = arr.split(",");
var dataName = new Array();
for(var i=0;i<dataInfo.length;i++){
 dataName[i] = i+'：00';
}
</script>
json;
            $title .= date("(Y年m月d日)",time());
            break;
    }

    //$chart->setDataSet($dataSet);


    include "tpl/count_list.php";
}

?>
