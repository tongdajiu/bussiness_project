<div class="content_title">关注回复管理&nbsp;</div>

<div class="search">
	<form action="" id="regform"  method="get">
		<input type='hidden' name='module' value='tp_subscribe'  />
        <input type='hidden' name='act' value='update'  />
        <table>
            <tr>
                <td>
                    <label>关注推送方式:</label>
                    <select name="type">
						<option value="Text" <?php echo $getModule == 'Text' ? 'selected' : '' ?> >文本信息</option>
						<option value="Img" <?php echo $getModule == 'Img' ? 'selected' : '' ?> >图文信息</option>
					</select>
                </td>
                <td>
                    <input type="submit" value=" 点击更改 " class="btn btn-red" />
                </td>

            </tr>
        </table>
    </form>
</div>



<!--------------------------------------------------------	文本形式  -------------------------------------------------------->
<?php if ( $getModule == 'Text' ){ ?>

<div id="tablewrapper">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" style="margin:0 0 20px;">
		<thead>
			<tr>
				<th><h3>ID</h3></th>
				<th><h3>关键词</h3></th>
				<th><h3>内容</h3></th>
				<th><h3>创建时间</h3></th>
				<th><h3>更新时间</h3></th>
				<th><h3>点击次数</h3></th>
				<th><h3>操作</h3></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $arrTxt->id ?>" /> <?php echo $arrTxt->id ?></td>
				<td><?php echo $arrTxt->keyword; ?></td>
				<td style="line-height:20px;"><?php echo  $arrTxt->text; ?></td>
				<td><?php echo date("Y-m-d",$arrTxt->createtime); ?></td>
				<td><?php echo date("Y-m-d",$arrTxt->updatetime); ?></td>
				<td><?php echo $arrTxt->click; ?></td>
				<td><a href="?module=tp_text&from=subscribe&act=edit&id=<?php echo $arrTxt->id; ?>" class="btn btn-green">编辑</a></td>
			</tr>
		</tbody>
	</table>
</div>
<!--------------------------------------------------------	图文形式  -------------------------------------------------------->
<?php }else{ ?>
<div class="t_r_btn">
    <a class="btn btn-big btn-blue" href="?module=tp_img&act=add&from=subscribe">添加图文信息</a>
</div>
<div id="tablewrapper">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" style="margin:0 0 20px;">
		<thead>
			<tr>
				<th><h3>ID</h3></th>
				<th><h3>关键词</h3></th>
				<th><h3>标题</h3></th>
				<th><h3>封面图片</h3></th>
				<th><h3>创建时间</h3></th>
				<th><h3>更新时间</h3></th>
				<th><h3>点击数</h3></th>
				<th><h3>操作</h3></th>
			</tr>
		</thead>

		<tbody>
			<?php if ( is_array( $arrImg ) ){ ?>
			<?php foreach ($arrImg as $row) { ?>
			<tr>
				<td><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $row->id ?>" /> <?php echo $row->id ?></td>
				<td><?php echo $row->keyword; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><img src="<?php echo $row->pic; ?>" alt="" width="150"></td>
				<td><?php echo date("Y-m-d",$row->createtime); ?></td>
				<td><?php echo date("Y-m-d",$row->uptatetime); ?></td>
				<td><?php echo $row->click; ?></td>
				<td>
					<a href="?module=tp_img&from=subscribe&act=edit&id=<?php echo $row->id; ?>" class="btn btn-green">编辑</a>
					<a href="javascript:void(0)" class="btn btn-red" onclick='del(<?php echo $row->id; ?>)'>删除</a>
				</td>

			</tr>
			<?php }} ?>
		</tbody>
	</table>
</div>
<?php } ?>

<script>
	function del(id)
	{
		if ( confirm('确认删除？') )
		{
			location.href = '?module=tp_img&from=subscribe&act=del&id=' + id;
		}

	}
</script>