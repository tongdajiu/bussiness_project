<?php
/**
  * wechat php test
  */
/**
  * wechat php test
  */
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once SCRIPT_ROOT.'logic/tp_textBean.php';
require_once SCRIPT_ROOT.'logic/tp_imgBean.php';
require_once SCRIPT_ROOT.'logic/tp_keywordBean.php';
require_once SCRIPT_ROOT.'logic/userBean.php';
require_once SCRIPT_ROOT.'logic/integral_recordBean.php';

//define your token
define("TOKEN", "weixin");

$ib = new tp_keywordBean();
$wechatObj = new wechatCallbackapiTest();

//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
    	global $db;
    	$tb = new tp_textBean();
    	$mb = new tp_imgBean();
    	$ib = new tp_keywordBean();
    	$ub = new userBean();
		$irb = new integral_recordBean();

		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
//			$MsgType = trim($postObj->MsgType);
//			$Event = trim($postObj->Event);
			$EventKey = trim($postObj->EventKey);
			$keyword = trim($postObj->Content);
			$MsgType = trim($postObj->MsgType);
			$Event = trim($postObj->Event);
			$Ticket = trim($postObj->Ticket);



//			$time = time();
			$time = time();
 			if($Event=="subscribe"){
				$obj=$ib->get_keyword($db,"subscribe");
				if($obj){
					if($obj->module=="Text"){
						$text=$tb->detail($db,$obj->pid);
						$textTpl = "<xml>
								    <ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<Event><![CDATA[%s]]></Event>
									<EventKey><![CDATA[%s]]></EventKey>
									<Ticket><![CDATA[%s]]></Ticket>
									<Content><![CDATA[%s]]></Content>
									<FuncFlag>0</FuncFlag>
									</xml>";											
              			$msgType = "text";
              			$contentStr=strip_tags($text->text);


						if($Ticket!=''){
						// =============如果为扫描二维码，则判断是否需要注册用户 ===========
						//if($img!=null && $img->keyword==6488){
						$obj_user = $ub->detail_openid($db,$fromUsername);
						if($obj_user == null || $obj_user == ''){
							$access_token=get_token();
							$openid_userinfo = get_userinfo($access_token,$fromUsername);
							//当前用户随机生成推荐码
							while(true){
								$chars = "0123456789";  
								$user_minfo ="";  
								for ( $i = 0; $i < 7; $i++ )  {  
									$user_minfo.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
								}
								$obj = $ub->detail_minfo($db,$user_minfo);
								if($obj == null){
									break;
								}
							}
							$userid = $ub->create_openid($fromUsername,$openid_userinfo["nickname"],$openid_userinfo["sex"],$user_minfo,$minfo,$db);
							$ub->update_add_type($db,$userid,1);
							$obj = $ub->detail_openid($db,$fromUsername);
							$ub->update_integral($db,500,$userid);
							$irb->create($type=2,$status=1,$userid,$pin_id=0,$pin_type=0,$order_id=0,500,time(),$db);
						}
						//}
						// ==========================================================
							
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL,'http://cha.gdbwt.com/qrsend.php?openid='.$fromUsername);

      
        ob_start();

        curl_exec($ch);
        ob_get_contents();
        ob_end_clean();
		curl_close($ch);
						}

			$KDatetime=date('H:i d/m/Y',time());
			$KFile='tmp_txt.txt';
			$KContent="Ticket:".$Ticket."\n fromUsername:".$fromUsername."\n toUsername:".$toUsername."\n EventKey:".$EventKey."\n keyword:".$keyword."\n MsgType:".$MsgType."\n Event:".$Event."\n count:".$count."\n textTpl:".$textTpl."\n Time:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);

              			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$Event,$EventKey,$Ticket,$contentStr);
                		echo $resultStr;
					}
				}
 			}else if($Event=="LOCATION"){
				$db->query("insert into user_location(openid,longitude,latitude,addTime) values('".trim($postObj->FromUserName)."','".trim($postObj->Longitude)."','".trim($postObj->Latitude)."','".time()."')");
			}
			if(!empty($keyword)){
				$obj=$ib->get_keyword($db,$keyword);
				if($obj){
					if($obj->module=="Text"){
						$text=$tb->detail($db,$obj->pid);
					  	//$ib->create($text->text,33,"2","2",$db);
						$textTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<Content><![CDATA[%s]]></Content>
									<FuncFlag>0</FuncFlag>
									</xml>";
              			$msgType = "text";
              			$contentStr=strip_tags($text->text);
              			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                		echo $resultStr;
					}elseif($obj->module=="Img"){

						$img=$mb->get_results_type($db,$obj->pid);
						//$count=count($img);
						//$ib->create($count,2,'2','2',$db);
						
						$msgType = "news";
 						$textTpl = "<xml>
 									<ToUserName><![CDATA[%s]]></ToUserName>
 									<FromUserName><![CDATA[%s]]></FromUserName>
 									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<ArticleCount>%s</ArticleCount>
									<Articles>";
						$dfsd = "<item>
							   	 <Title><![CDATA[%s]]></Title>
								 <Description><![CDATA[%s]]></Description>
								 <PicUrl><![CDATA[%s]]></PicUrl>
								 <Url><![CDATA[%s]]></Url>
								 </item>";

						$textTpl.=$dfsd;
						$textTpl .= "</Articles></xml> ";

						if(strpos($img->url, "?")){
                           $str="&";
                        }else{
                        	$str="?";
                        }
						$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,1,
												 $img->title,$img->text,$img->pic,$img->url.$str."wech_id=".$fromUsername);


						echo $resultStr;
					}
				}else{

				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							</xml>";


              		$msgType = "transfer_customer_service";
              		//$contentStr="��ã�����С��������ʲô�ܰﵽ��?";
              			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
                	echo $resultStr;
				}
			}elseif($EventKey){
				$EventKey=str_replace('qrscene_','',$EventKey);
				$obj=$ib->get_keyword($db,$EventKey);
				if($obj){
					if($obj->module=="Text"){
/**			$KDatetime=date('H:i d/m/Y',time());
			$KFile='tmp_txt.txt';
			$KContent="Text=Ticket:".$Ticket."\n fromUsername:".$fromUsername."\n toUsername:".$toUsername."\n EventKey:".$EventKey."\n keyword:".$keyword."\n MsgType:".$MsgType."\n Event:".$Event."\n Time:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);

		*/				$text=$tb->detail($db,$obj->pid);
						$textTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<Event><![CDATA[%s]]></Event>
									<EventKey><![CDATA[%s]]></EventKey>
									<Ticket><![CDATA[%s]]></Ticket>
									<Content><![CDATA[%s]]></Content>
									<FuncFlag>0</FuncFlag>
									</xml>";
              			$msgType = "text";
              			$contentStr=strip_tags($text->text);
              			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$Event,$EventKey,$Ticket,$contentStr);
                		echo $resultStr;
					}elseif($obj->module=="Img"&&$Ticket!=''){
					
						$img=$mb->get_results_type($db,$obj->pid);
						//$count=count($img);
						//$ib->create($count,2,'2','2',$db);
						
						// =============如果为扫描二维码，则判断是否需要注册用户 ===========
						if($img!=null && $img->keyword==6488){
						$obj_user = $ub->detail_openid($db,$fromUsername);
						if($obj_user == null || $obj_user == ''){
							$access_token=get_token();
							$openid_userinfo = get_userinfo($access_token,$fromUsername);
							//当前用户随机生成推荐码
							while(true){
								$chars = "0123456789";  
								$user_minfo ="";  
								for ( $i = 0; $i < 7; $i++ )  {  
									$user_minfo.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
								}
								$obj = $ub->detail_minfo($db,$user_minfo);
								if($obj == null){
									break;
								}
							}
							$userid = $ub->create_openid($fromUsername,$openid_userinfo["nickname"],$openid_userinfo["sex"],$user_minfo,$minfo,$db);
							$ub->update_add_type($db,$userid,1);
							$obj = $ub->detail_openid($db,$fromUsername);
							$ub->update_integral($db,500,$userid);
							$irb->create($type=2,$status=1,$userid,$pin_id=0,$pin_type=0,$order_id=0,500,time(),$db);
						}
						}
						// ==========================================================
						
						$msgType = "news";
 						$textTpl = "<xml>
 									<ToUserName><![CDATA[%s]]></ToUserName>
 									<FromUserName><![CDATA[%s]]></FromUserName>
 									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<ArticleCount>%s</ArticleCount>
									<Articles>";
						$dfsd = "<item>
							   	 <Title><![CDATA[%s]]></Title>
								 <Description><![CDATA[%s]]></Description>
								 <PicUrl><![CDATA[%s]]></PicUrl>
								 <Url><![CDATA[%s]]></Url>
								 </item>";

						$textTpl.=$dfsd;
						$textTpl .= "</Articles></xml> ";

						if(strpos($img->url, "?")){
                           $str="&";
                        }else{
                        	$str="?";
                        }
						$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,1,
												 $img->title,$img->text,$img->pic,$img->url.$str."wech_id=".$fromUsername);


						echo $resultStr;
					}elseif($obj->module=="Img"){



						$img=$mb->get_results_type($db,$obj->pid);
						$count=count($img);
 						$textTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<Event><![CDATA[%s]]></Event>
									<EventKey><![CDATA[%s]]></EventKey>
									<Ticket><![CDATA[%s]]></Ticket>
									<ArticleCount>%s</ArticleCount>
									<Articles>";
						$dfsd = "<item>
								 <Title><![CDATA[%s]]></Title>
								 <Description><![CDATA[%s]]></Description>
								 <PicUrl><![CDATA[%s]]></PicUrl>
								 <Url><![CDATA[%s]]></Url>
								 </item>";
						foreach ($img as $row){
							$textTpl.=$dfsd;
						}
						$textTpl .= "</Articles>
									 </xml> ";
						$msgType = "Event";



			$KDatetime=date('H:i d/m/Y',time());
			$KFile='tmp_txt.txt';
			$KContent="Img=Ticket:".$Ticket."\n fromUsername:".$fromUsername."\n toUsername:".$toUsername."\n EventKey:".$EventKey."\n keyword:".$keyword."\n MsgType:".$MsgType."\n Event:".$Event."\n count:".$count."\n textTpl:".$textTpl."\n Time:".$KDatetime."\n";
			file_put_contents($KFile,$KContent,FILE_APPEND);

						if($count==1){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$Event,$EventKey,$Ticket,$count,$img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername);
						}elseif($count==2){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername);
						}elseif($count==3){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
							if(strpos($img[2]->url, "?")){$str3="&";}else{$str3="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername,
												 $img[2]->title,$img[2]->text,$img[2]->pic,$img[2]->url.$str3."wech_id=".$fromUsername);
						}elseif($count==4){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
							if(strpos($img[2]->url, "?")){$str3="&";}else{$str3="?";}
							if(strpos($img[3]->url, "?")){$str4="&";}else{$str4="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername,
												 $img[2]->title,$img[2]->text,$img[2]->pic,$img[2]->url.$str3."wech_id=".$fromUsername,
												 $img[3]->title,$img[3]->text,$img[3]->pic,$img[3]->url.$str4."wech_id=".$fromUsername);
						}elseif($count==5){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
							if(strpos($img[2]->url, "?")){$str3="&";}else{$str3="?";}
							if(strpos($img[3]->url, "?")){$str4="&";}else{$str4="?";}
							if(strpos($img[4]->url, "?")){$str5="&";}else{$str5="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername,
												 $img[2]->title,$img[2]->text,$img[2]->pic,$img[2]->url.$str3."wech_id=".$fromUsername,
												 $img[3]->title,$img[3]->text,$img[3]->pic,$img[3]->url.$str4."wech_id=".$fromUsername,
												 $img[4]->title,$img[4]->text,$img[4]->pic,$img[4]->url.$str5."wech_id=".$fromUsername);
						}elseif($count==6){
							if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
							if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
							if(strpos($img[2]->url, "?")){$str3="&";}else{$str3="?";}
							if(strpos($img[3]->url, "?")){$str4="&";}else{$str4="?";}
							if(strpos($img[4]->url, "?")){$str5="&";}else{$str5="?";}
							if(strpos($img[5]->url, "?")){$str6="&";}else{$str6="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername,
												 $img[2]->title,$img[2]->text,$img[2]->pic,$img[2]->url.$str3."wech_id=".$fromUsername,
												 $img[3]->title,$img[3]->text,$img[3]->pic,$img[3]->url.$str4."wech_id=".$fromUsername,
												 $img[4]->title,$img[4]->text,$img[4]->pic,$img[4]->url.$str5."wech_id=".$fromUsername,
												 $img[5]->title,$img[5]->text,$img[5]->pic,$img[5]->url.$str6."wech_id=".$fromUsername);
    					}elseif($count==7){
    						if(strpos($img[0]->url, "?")){$str="&";}else{$str="?";}
    						if(strpos($img[1]->url, "?")){$str2="&";}else{$str2="?";}
    						if(strpos($img[2]->url, "?")){$str3="&";}else{$str3="?";}
    						if(strpos($img[3]->url, "?")){$str4="&";}else{$str4="?";}
    						if(strpos($img[4]->url, "?")){$str5="&";}else{$str5="?";}
    						if(strpos($img[5]->url, "?")){$str6="&";}else{$str6="?";}
    						if(strpos($img[6]->url, "?")){$str7="&";}else{$str7="?";}
							$resultStr = sprintf($textTpl, $fromUsername,$toUsername, $time, $msgType,$count,
												 $img[0]->title,$img[0]->text,$img[0]->pic,$img[0]->url.$str."wech_id=".$fromUsername,
												 $img[1]->title,$img[1]->text,$img[1]->pic,$img[1]->url.$str2."wech_id=".$fromUsername,
												 $img[2]->title,$img[2]->text,$img[2]->pic,$img[2]->url.$str3."wech_id=".$fromUsername,
												 $img[3]->title,$img[3]->text,$img[3]->pic,$img[3]->url.$str4."wech_id=".$fromUsername,
												 $img[4]->title,$img[4]->text,$img[4]->pic,$img[4]->url.$str5."wech_id=".$fromUsername,
												 $img[5]->title,$img[5]->text,$img[5]->pic,$img[5]->url.$str6."wech_id=".$fromUsername,
												 $img[6]->title,$img[6]->text,$img[6]->pic,$img[6]->url.$str7."wech_id=".$fromUsername);
						}
						echo $resultStr;
					}
				}
			}else{
				echo "Input something...";
			}
        }else {
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
}
?>