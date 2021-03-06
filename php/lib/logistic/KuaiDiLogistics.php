<?php
class kuaidi extends Logistics{
		
	public function setCodeId($express_code_id)
	{
		$this->code_id = $express_code_id;
	}
	
	
	/*
	 * 返回$data array      		快递数组
	 * @param $express_type     快递名称
	 * @param $express_number   快递的单号
	 * $data['data']        	快递实时查询的状态 array
	 */
	public function getExpress($express_type,$express_number)
	{
		
		//key为系统定义的固定值，var为实际接口参数
		$ExpressType = array(
			'ziqu'=>'ziqu',
			'shunfeng' => 'shunfeng',
			'shentong' => 'shentong',
			'zhongtong' => 'zhongtong',
			'yuantong' => 'yuantong',
			'huitong' => 'huitong',
			'tiantian' => 'tiantian',
			'yunda' => 'yunda',
			'dhl' => 'dhl',
			'zhaijisong' => 'zhaijisong',
			'debang' => 'debang',
			'ems' => 'ems',
			'eyoubao' => 'eyoubao',
			'guotong' => 'guotong',
			'longbang' => 'longbang',
			'lianbang' => 'lianbang',
			'tnt' => 'tnt',
			'xinbang' => 'xinbang',
			'zhongtie' => 'zhongtie',
			'zhongyou' => 'zhongyou'
		);
			
		$result = parent::getcontent("http://api.kuaidi.com/openapi.html?id={$this->code_id}&com={$ExpressType[$express_type]}&nu={$express_number}&show=0&muti=0&order=asc");
		
		$result = json_decode($result);

		$data = parent::objarray_to_array($result);

		return $data;
	}
	
}
?>