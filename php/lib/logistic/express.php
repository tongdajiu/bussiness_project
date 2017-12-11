<?php
class Express{
	public function setInterface($logistics_interface)
	{
		switch ($logistics_interface)
		{
			case 'kuaidi':
				require_once LOGISTIC_DIR.'/KuaiDiLogistics.php';
				return new kuaidi();
			break;
		}
	}
}
?>