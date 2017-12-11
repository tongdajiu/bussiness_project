<?php
define('HN1', true);
require_once('global.php');
require_once(MODEL_DIR.'/DistributorApplicationModel.class.php');
$act = isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : '';

switch( $act )
{
	default:
		$distributor_application  = new DistributorApplicationModel($db);

		$rs = $distributor_application->get(array( 'userid' => $_SESSION['userInfo']->id ));
		if ( $rs != null )
		{
			echo 0;
			exit;
		}

		$data = array(
			'userid'  => $_SESSION['userInfo']->id,
			'name'	  => $_SESSION['userInfo']->name,
			'add_time'=> time()
		);
		$rs = $distributor_application->add($data);
		echo $rs === FALSE ? 0 : 1;

}
?>