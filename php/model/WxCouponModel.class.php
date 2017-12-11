<?php
/**
 * 微信优惠券模型
 */
class WxCouponModel extends Model
{
	public function __construct($db, $table='')
	{
	    $table = 'wx_coupon';
	    parent::__construct($db, $table);
	}
}
?>