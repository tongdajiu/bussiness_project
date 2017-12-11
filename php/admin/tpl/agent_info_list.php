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
<div class="content_title">加盟分销商信息</div>

<div class="search">
    <form action="index.php?module=agent_info_action" method="GET" name="myForm2" >
        <table>
            <tr>
                <td>
                    <select id="u54" class="u54" name="condition"  style="width:150px;">
                        <option value="">请选择</option>
                        <option value="name" <?php if($condition=="name"){echo "selected";}?>>真实姓名</option>
						<option value="tel" <?php if($condition=="tel"){echo "selected";}?>>手机号码</option>
						<option value="number" <?php if($condition=="number"){echo "selected";}?>>身份证号码</option>
						<option value="email" <?php if($condition=="email"){echo "selected";}?>>邮箱</option>
                    </select>
                </td>
                <td>
                   <input type="text" id="keys" name="keys" value="<?php echo $keys ?>" />
                </td>
                <td>
                    <input type="hidden" name="module" value="agent_info_action">
                    <input type="submit" value=" 搜索 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>

 </div><div id="tablewrapper">
    <form action="index.php" method="POST" name="myForm" >
        <input type="hidden" name="module" value="agent_info_action">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="status" value="">
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
            <thead>
                <tr>
                    <th><h3>用户ID</h3></th>
                    <th><h3>真实姓名</h3></th>
                    <th><h3>手机号码</h3></th>
                    <th><h3>邮箱</h3></th>
                    <th><h3>身份证号码</h3></th>
                    <th><h3>保证金</h3></th>
                    <th><h3>加盟费</h3></th>
                    <th><h3>加盟时间</h3></th>
                    <th><h3>添加时间</h3></th>
                    <th><h3>信息</h3></th>
                    <th><h3>操作</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            foreach ($agentinfoList['DataSet'] as $row) {
            $i++;
            ?>
            <tr>
                <td><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id; ?>"><?php echo $i; ?></label></td>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->mobile; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->id_number; ?></td>
                <td><?php echo $row->pre_money; ?></td>
                <td><?php echo $row->join_money; ?></td>
                <td><?php echo date('Y-m-d H:s:m',$row->join_time); ?></td>
                <td><?php echo date('Y-m-d H:s:m',$row->addTime); ?></td>
                <td>
                    <?php if(VersionModel::isOpen('distributorSubordinateOrderStatistics')){ ?><a href="?module=agent_info_action&act=view&id=<?php echo $row->userid;?>" class="btn">下线消费记录</a><?php } ?>
                    <?php if(VersionModel::isOpen('distributorWalletManagement')){ ?><a class="btn" href="?module=agent_info_action&act=commission&id=<?php echo $row->id;?>&lpage=<?php echo $page;?>">佣金记录</a><?php } ?>
                </td>
                <td>
                    <a href="?module=agent_info_action&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
                    <a href="?module=agent_info_action&act=del&id=<?php echo $row->id; ?>" class="btn btn-red" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </form>
    <div id="tablefooter">
        <div id="tablenav" style="width:500px;">
             <div>
             <a href="javascript://" onclick="selectCheckBox(1);" >全选</a>&nbsp;|&nbsp;
             <a href="javascript://" onclick="selectCheckBox(0);" >全不选</a>&nbsp;|&nbsp;
             <a href="javascript://" onclick="return replace();" >删除</a>
            <!--
            <a href="javascript://" onclick="return u_status(0);" >正常</a>&nbsp;|&nbsp;
            <a href="javascript://" onclick="return u_status(1);" >暂停合作</a>
            -->
             </div>
         </div>


        <div id="tablelocation">
            <div>
                <span class="STYLE1">共<?php echo $agentinfoList['RecordCount']; ?>条纪录，当前第<?php echo $agentinfoList['CurrentPage']; ?>/<?php echo $agentinfoList['PageCount']; ?>页，每页<?php echo $agentinfoList['PageSize']; ?>条纪录</span>
                <a href="<?php echo $url . $agentinfoList['First']; ?>">[第一页]</a>
                <a href="<?php echo $url . $agentinfoList['Prev']; ?>">[上一页]</a>
                <a href="<?php echo $url . $agentinfoList['Next']; ?>">[下一页]</a>
                <a href="<?php echo $url . $agentinfoList['Last']; ?>">[最后一页]</a>

            </div>
            <div class="page"></div>
        </div>
    </div>
</div>
