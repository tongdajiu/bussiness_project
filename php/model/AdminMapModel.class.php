<?php
/**
 * 后台功能模型
 */
class AdminMapModel extends Model
{
	private static $versionTypes = array(0=>'普通版', 1=>'标准版', 2=>'旗舰版');

	 public function __construct($db, $table='')
	 {
        $table = 'admin_map';
        parent::__construct($db, $table);
    }


	/**
	 *	添加信息(单条，私有)
	 *	@param array $arrParam	参数 （ Moudle：模块、 Function：功能、 Actions：操作、 Pid：父类ID、 Name：功能名称 ）
	 *	@return int
	 */
	private function _setInfo( $arrParam )
	{
		$rs = $this->getOne( $arrParam['Moudle'], $arrParam['Function'], $arrParam['Actions'] );

		if ( $rs == NULL )
		{
			$arrParam = array(
				'pid'		=> $arrParam['Pid'],
				'moudle'	=> $arrParam['Moudle'],
				'functions' => $arrParam['Function'],
				'actions'	=> $arrParam['Actions'],
				'name'		=> $arrParam['Name']
			);

			return $this->add( $arrParam );
		}
		else
		{
			return $rs->id;
		}
	}



	/**
	 *	获取参入的方式是否有值
	 *	@param string  $Moudle		模块
	 *	@param string  $Function	功能
	 *	@param string  $Actions		操作
	 *	@return bool
	 */
	public function getOne( $Moudle, $Function, $Actions )
	{
		$arrWhere = array(
			'moudle'	=> $Moudle,
			'functions' => $Function,
			'actions'	=> $Actions
		);

		return $this->get( $arrWhere, array('id') );
	}


	/**
	 *	添加信息(批量)
	 *	@param array $arrCfg	/inc/vercfg_func.php中的内容
	 *	@return bool
	 */
	public function addInfo( $arrCfg )
	{

		$nNowVersion = $this->getVersion();

		foreach( $arrCfg as $arrFatherVal )
		{

			$arrParam = array(
				'Moudle' 	=> $arrFatherVal['name'],
				'Function'	=> '',
				'Actions'	=> '',
				'Pid'		=> 0,
				'Name'		=> $arrFatherVal['title']
			);

			$nFatherId = $this->_setInfo( $arrParam );

			if ( isset($arrFatherVal['menu']) )
			{
				foreach( $arrFatherVal['menu'] as $arrChildVal )
				{
					if ( in_array( $nNowVersion, $arrChildVal['versions'] ) )		// 看是否在权限内
					{
						$arrParam = array(
							'Moudle' 	=> $arrFatherVal['name'],
							'Function'	=> $arrChildVal['name'],
							'Actions'	=> '',
							'Pid'		=> $nFatherId,
							'Name'		=> $arrChildVal['title']
						);
						$nChildId = $this->_setInfo( $arrParam );

						if ( isset($arrChildVal['menu']) )
						{
							foreach( $arrChildVal['menu'] as $arrSubChildVal )
							{
								$arrParam = array(
									'Moudle' 	=> $arrFatherVal['name'],
									'Function'	=> $arrChildVal['name'],
									'Actions'	=> $arrSubChildVal['name'],
									'Pid'		=> $nChildId,
									'Name'		=> $arrSubChildVal['title']
								);
								$nSubChildId = $this->_setInfo( $arrParam );
							}
						}
					}

				}
			}
		}

		return true;
	}

	public function getList()
	{
		$arrList = $this->getAll( array('pid'=>0),array(),OBJECT,'',array('id','name') );

		if ( is_array( $arrList ) )
		{
			foreach( $arrList as $key=>$FatherList )
			{
				$arrList[$key]->child = $this->getAll( array('pid'=>$FatherList->id),array(),OBJECT,'',array('id','name') );

				if ( is_array($arrList[$key]->child) )
				{
					foreach( $arrList[$key]->child as $sub_key=>$ChildList )
					{
						$arrList[$key]->child[$sub_key]->child = $this->getAll( array('pid'=>$ChildList->id),array(),OBJECT,'',array('id','name') );
					}
				}
			}
		}

		return $arrList;
	}

	/**
     * 获取版本
     *
     * @return integer
     */
    private static function getVersion()
    {
    	$version_type = INC_DIR.'/lock';
        if(file_exists($version_type))
        {
            $verFlag = file_get_contents($version_type);
            $verFlag = in_array($verFlag, array_keys(self::$versionTypes)) ? intval($verFlag) : 0;
        }
        else
        {
            $verFlag = 0;
        }

        return $verFlag;
    }

}
?>