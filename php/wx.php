<?php
/**
 * 微信交互
 */
define('HN1', true);
require_once('./global.php');
require_once( MODEL_DIR . '/TpKeywordModel.class.php' );

$TpKeywordModel = new TpKeywordModel( $db );

//$arrGetList = $TpKeywordModel->getKeywordList( '图片', $site );
//var_dump($arrGetList);
//
//exit;

$objWX->valid();
$type = $objWX->getRev()->getRevType();

switch($type)
{
	// 文本
    case Wechat::MSGTYPE_TEXT:

        $keyword = $objWX->getRevContent();

        $keyword = strtolower($keyword);

        if ( $keyword == 'www' )
        {
            $response = "欢迎来到贝氏旗舰店，点击<a href='http://www.ipaner.com'>进入商城</a>";
            $objWX->text($response)->reply();
        }
        else
        {
            $response = "Welcome";
            $objWX->text($response)->reply();
        }
        /*
        $arrGetList = $TpKeywordModel->getKeywordList( $keyword, $site );
        if ( $arrGetList == null )
        {
        	$response = "Welcome";
        	$objWX->text($response)->reply();
        }
        elseif(  )
		elseif ( $arrGetList['type'] == 'Text' )
        {
			$response = $arrGetList['data'];
        	$objWX->text($response)->reply();
        }
        elseif ( $arrGetList['type'] == 'News' )
        {
			$response = $arrGetList['data'];
        	$objWX->news($response)->reply();
        }
        */

        exit;
    break;

	// 事件
    case Wechat::MSGTYPE_EVENT:

		$arrRebEvent = $objWX->getRevEvent();
    	switch($arrRebEvent['event'])		// 获取事件类型
    	{
    		case Wechat::EVENT_SUBSCRIBE:		// 关注订阅号
    			$arrGetList = $TpKeywordModel->getSubscribeList( $site );


    			$objWX->writeLog($arrGetList['type']);


    			if ( $arrGetList == null )
		        {
		        	$response = "Welcome";
		        	$objWX->text($response)->reply();
		        }
		        elseif ( $arrGetList['type'] == 'Text' )
		        {
					$response = $arrGetList['data'];
		        	$objWX->text($response)->reply();
		        }
		        elseif ( $arrGetList['type'] == 'News' )
		        {
					$response = $arrGetList['data'];
		        	$objWX->news($response)->reply();
		        }
    		break;
    	}

}

?>