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
</SCRIPT>

<div class="content_title">自定义菜单管理</div>

<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=tp_diymen_class&act=set_menu">同步到公众平台</a>
    <a class="btn btn-big btn-blue" href="?module=tp_diymen_class&act=del_menu">移除微信菜单</a>
</div>

<div id="tablewrapper">
	<dl>
		<h3> 设置前需仔细阅读以下内容：</h3>
	  	<dd style="margin:10px;">
	  		<p>1、移除微信菜单</p>
			<p>点击该按钮之后，会移除微信上现有的菜单信息 （如不需要移除，请慎用该功能）；</p>
		</dd>
		<dd style="margin:10px;">
			<p>2、同步到公众平台</p>
			<p>会将设置好的菜单内容同步到微信菜单中，如果哪个位置不需要显示，则菜单标题请设置为空</p>
		</dd>

		<dd style="margin:10px;">
			<p>说明：</p>
			<p>下面菜单栏中出现 "--" 的符号，则表示在微信菜单中不会显示该内容。</p>
		</dd>
	</dl>


    <form action="index.php" method="POST" name="myForm" >
        <div class="tp_diymen">
	        <?php foreach ( $arrData as $row) { ?>
	        	<ul>
	        		<?php foreach ( $row->child as $child ){ ?>
	        			<li>
	        				<a href="?module=tp_diymen_class&act=edit&id=<?php echo $child->id; ?>">
	        					<?php echo $child->title == '' ? '--' : $child->title; ?>
	        				</a>
	        			</li>
	        		<?php } ?>
	        		<li class="tp_diymen_a">
	        			<a href="?module=tp_diymen_class&act=edit&id=<?php echo $row->id; ?>">
	        				<?php echo $row->title == '' ? '--' : $row->title; ?>
	        			</a>
	        		</li>
	        	</ul>
			<?php } ?>
        </div>
    </form>
</div>


