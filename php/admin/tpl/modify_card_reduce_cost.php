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
    function replace(){
        if(confirm("确定要删除该记录吗?该操作不可恢复!"))
        {
            myForm.method='GET';
            myForm.act.value='del';
            myForm.submit();
            return true;
        }
        return false;

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
    function modify_reducecost_of_card(){

            myForm.method='GET';
            myForm.act.value='modify_reducecost_of_card';
			myForm.submit();
			try {
				parent.window.hs.getExpander().close();
			} catch (e) {
				return false;
			}
            return true;
    }



</SCRIPT>

<script type="text/javascript" src="../res/js/jquery-1.4.2.min.js"></script>
<link href="../res/js/highslide/highslide.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../res/js/highslide/highslide-full.packed.js"></script>
<script type="text/javascript">
hs.showCredits = 0;
hs.padToMinWidth = true;
hs.preserveContent = false;
hs.graphicsDir = '../js/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';


</script>

<div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="<?php echo nowmodule;?>">
        <input type="hidden" name="act" value="modify_reducecost_of_card">
        <input type="hidden" name="card_id" value="<?php echo $card_id;?>">

        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
				<tr>

				<td colspan="2">卡券ID:&nbsp;&nbsp;【<?php echo $card_id;?>】</td>
				</tr>
	            <tr>
					<th width="30px"><h3>面值</h3></th>
					<th width="30px"><h3>操作</h3></th>
	            </tr>
            </thead>
			<tbody>

				<tr>
					<td><input name="reduce_cost" type="number" value="<?php echo $re_wx_card->reduce_cost;?>" /></td>
					<td><input type="submit" class="continue" id="btn_next" value=" 确定 " onclick="return modify_reducecost_of_card();" style="color:#009933;"/><br><input type="reset" class="continue" id="btn_next" value=" 重置 " /></td>
				</tr>
            </tbody>
        </table>
    </form>

</div>
