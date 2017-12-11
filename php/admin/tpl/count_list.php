<script src="../res/js/Chart.js/Chart.js"></script>
<SCRIPT language=JavaScript>
    function selectCheckBox(type){
        var checkBoxs = document.getElementsByName("id[]");
        var state = false;
        switch(type){
            case 0:
                state = false;
                break;
            case 1:
                state = true;
                break;
        }
        for(var i = 0,len = checkBoxs.length; i < len; i++){
            var item = checkBoxs[i];
            item.checked = state;
        }
    }
    function unselectAll(){
        var obj = document.fom.elements;
        for (var i=0;i<obj.length;i++){
            if (obj[i].name == "id[]"){
                if (obj[i].checked==true) obj[i].checked = false;
                else obj[i].checked = true;
            }
        }
    }

    function u_status(ustatus){
        if(confirm("确定修改状态！"))
        {
            myForm.method='GET';
            myForm.act.value='update_status';
            myForm.status.value=ustatus;
            myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>

<script type="text/javascript" src="../res/utils/My97DatePicker/WdatePicker.js"></script>
<div class="content_title">统计汇总</div>

<div class="search">
    <table>
        <tr>
            <td colspan="3">
                <label>时间阶段:</label>
                <form style="display:inline" action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                    <input type="hidden" name="act" value="<?php echo $act;?>">
                    <input type="hidden" name="day" value="today">
                    <input type="submit" value=" 今天 " class="btn btn-blue" />
                </form>

                <form style="display:inline" action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                    <input type="hidden" name="act" value="<?php echo $act;?>">
                    <input type="hidden" name="day" value="yesterday">
                    <input type="submit" value=" 昨天 " class="btn btn-blue" />
                </form>

                <form style="display:inline" action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
                    <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                    <input type="hidden" name="act" value="<?php echo $act;?>">
                    <input type="hidden" name="day" value="sevenDay">
                    <input type="submit" value=" 前七天 " class="btn btn-blue" />
                </form>
            </td>
        </tr>
        <form action="index.php?module=<?php echo nowmodule;?>" method="GET" name="myForm2" >
        <tr>
            <td>
                <label>开始时间:</label>
                <input type="text" name="starttime" id="starttime" value="<?php echo $start_time;?>" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\');}'})" />
            </td>
            <td>
                <label>结束时间:</label>
                <input type="text" name="endtime" id="endtime" value="<?php echo $end_time; ?>" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\');}'})" />
            </td>
            <td>
                <input type="hidden" name="module" value="<?php echo nowmodule;?>">
                <input type="hidden" name="act" value="<?php echo $act;?>">
                <input type="hidden" name="day" value="others">
                <input type="submit" value=" 统计 " class="btn btn-red" />
            </td>
        </tr>
        </form>
    </table>
</div>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <!--
        <img alt="Vertical bars chart" src="count_action.php" style="border: 1px solid gray;"/>
        -->
        <center><h1><?php echo $title; ?></h1></center>
        <div id="canvas_box">
            <canvas id="canvas"></canvas>
        </div>
    </form>
</div>
<?php echo $info;?>
<script>
    (function(){
        if((dataName[0].indexOf("-")>0) && (dataName.length>31)){
            doByMou();
        }
        function doByMou(){
            var data = 0, mou = 0, oldMou = 0;
            var newdataName = new Array();
            var newdataInfo = new Array();
            for(var i=0; i<dataName.length; i++){
                mou = dataName[i].split("-")[1];
                if(i==0){
                    oldMou = mou;
                    data = parseInt(dataInfo[i]);
                }else if((mou!=oldMou)||(i==dataName.length-1)){
                    newdataInfo.push(data);
                    newdataName.push(dataName[i-1].split("-")[0]+"-"+oldMou);
                    oldMou = mou;
                    data = parseInt(dataInfo[i]);
                }else{
                    data += parseInt(dataInfo[i]);
                }
            }
            dataName = newdataName;
            dataInfo = newdataInfo;
        }
    })();
    var barChartData = {
        labels : dataName,
        datasets : [
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,0.8)",
                highlightFill : "rgba(151,187,205,0.75)",
                highlightStroke : "rgba(151,187,205,1)",
                data : dataInfo
            }
        ]

    }
    window.onload = function(){
        var winWidth = window.innerWidth-30;
        var bar = document.getElementById("canvas_box");
        bar.style.width = winWidth+'px';

        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx).Bar(barChartData, {
            responsive : true
        });
    }
</script>