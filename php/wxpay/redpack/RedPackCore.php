<?php

	require_once "WxPayHelper.php";

	class RedPackCore extends WxPayHelper
	{
		private $value;
		private $url;


		public function __construct($type)
		{
			$this->value = array();
			$this->init( $type );
		}


		/**
		 * 根据类型做出现有的红包操作
		 * */
		private function init( $type )
		{
			switch ( $type )
			{
				case 'cash':
					$this->url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
				break;

				case 'group':
					$this->url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
				break;

				case 'error':
				break;
			}
		}


		/**
		 * 现金红包操作
		 * */
		public function cash_option()
		{
			$this->getNonceStr();
			$this->getMchBillno();
			$this->getMchId();
			$this->getWxAppId();
			$this->setTotalNum(1);
			$this->getClientIp();
			$this->getSign();

			$output_xml_data   = $this->setResponseXml($this->url);					// 生成xml
			return $this->get_xml_data($output_xml_data);							// 把获取的xml转换成arr
		}

	}
?>