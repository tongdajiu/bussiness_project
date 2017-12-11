<?php
/**
 * 管理员模型
 */
class AdminModel extends Model{

	 public function __construct($db, $table='')
	 {
        $table = 'admin';
        parent::__construct($db, $table);
    }

    /**
     * 生成操作记录
     *
     * @param array $data 数据
     *      aid 管理员id
     *      uname 管理员帐号
     *      name 管理员名称
     *      type 操作类型
     *      optitle 操作标题
     *      opcontent 操作内容
     * @return integer|boolean
     */
    public function genOpLog($data)
    {
		$newdata = array(
			'aid' => $data['aid'],
			'uname' => $data['uname'],
			'name' => $data['name'],
			'type' => $data['type'],
			'optitle' => $data['optitle'],
			'opcontent' => $data['opcontent'],
			'add_time' => time(),
		);
		return parent::add($newdata, 'admin_log');
    }

    public function getOpContent($obj,$arrParam, $table='')
    {
		$tablecfg = include(ADMIN_INC_DIR."/field.php");
		$cfgmap = $tablecfg[$table];
    	$rs = '';
		if ( is_array($arrParam) )
		{
			foreach( $arrParam as $key=>$val )
			{
				if($obj->{$key} != $val)
				{
					$rs .= $cfgmap[$key].':'.$obj->$key.'—>'.$val.'\n';
				}
			}
		}

		return $rs;
    }

	/**
	 * 获取加密过的密码
	 *
	 * @param string $pwd 明文密码
	 * @return string
	 */
	public function getEncryptionPassword($pwd){
		return md5($pwd);
	}
}
?>