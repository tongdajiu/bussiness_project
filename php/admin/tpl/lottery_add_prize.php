<!-- 用于添加奖品设置时调用 -->
	<dd>
		<ul class="ottList">
			<li>
				<label class="labelName">奖品:</label>
				<input type="hidden" id="prize" name="id[]" class="regTxt"  value="<?php echo $prize->id;?>" />
                <input type="text" id="prize" name="prize[]" class="regTxt"  value="<?php echo $info->prize;?>" />
				<div class="clear"></div>
			</li>
			<li>
                <label class="labelName">奖品类型:</label>
                <select class="prize_type" name="prize_type[]" class="select" style="WIDTH: 100PX;">
                    <?php foreach ( $PrizeType as  $key=>$prize ){ ?>
                    	<option value="<?php echo $key ?>"><?php echo $prize ?></option>
                   <?php } ?>
                </select>
                <select class="prize_val" name="prize_val[]" class="select" style="WIDTH: 100PX; display:none" >
                <option value="0">--</option>
                <?php foreach($couponList as $cl){?>
                <?php if($cl->status ==1){?>
                <option value="<?php echo $cl->id ;?>"><?php  echo $cl->name ;?></option>
                <?php }}?>
                </select>
				<div class="clear"></div>
			</li>
			<li>
				<label class="labelName">奖品数量:</label>
                <input type="text" id="number" name="number[]" class="regTxt"  value="" style="WIDTH: 100PX;"/>
				<div class="clear"></div>
			</li>
			<li>
				<label class="labelName">角度值:</label>
                <input type="text" id="pos" name="pos[]" class="regTxt"  value="" style="WIDTH: 100PX;"/>
				<div class="clear"></div>
			</li>
			<li>
				<label class="labelName">概  率:</label>
                <input type="text" id="chance" name="chance[]" class="regTxt"  value="" style="WIDTH: 100PX;"/>
				<div class="clear"></div>
			</li>

			<li class="lotteryDrop" onclick="dropLottery(this)">删除</li>
		</ul>
	</dd>

