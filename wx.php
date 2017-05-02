<?php
/**
  * wechat php test
  */
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('PRC');
require "../config/db.php";
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
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



	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}



	public function responseMsg()
	{

	$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
	    //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

	    if (!empty($postStr))
	    {
	        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

	        $file  = 'log.txt';
	        file_put_contents($file, date("Y-m-d H:i:s",time()).$postStr."\r\n",FILE_APPEND);
	        $RX_TYPE = trim($postObj->MsgType);

	        switch($RX_TYPE)
	        {
	            case "text":
	                $resultStr = $this->handleText($postObj);
	                break;
	            case "event":
	                $resultStr = $this->handleEvent($postObj);
	                break;
	            default:
	                $resultStr = "Unknow msg type: ".$RX_TYPE;
	                break;
	        }

	        echo $resultStr;
	    }
	    else
	    {
	        echo "";
	        exit;
	    }
	}






	public function handleEvent($postObj)
	{
	    $contentStr = "";
	    $fromUsername = $postObj->FromUserName;
	    $toUsername = $postObj->ToUserName;
	    $event=$postObj->Event;
	    
	    switch($event)
	    {
	        case "subscribe":
	    				$contentStr = "欢迎关注家族智库™微信公众平台"."\n"."寻找专业顾问请留言【家族智库】"."\n";		
	            break;
	        case "scancode_waitmsg":
	            $contentStr = $this->handleScan($postObj);
	            break;
	        case "scancode_push":
	            $contentStr = "扫码push"."\n";		
	            break;	            
	        default:
	            $resultStr = "Unknow msg type: ".$event;
	            break;
	    }
	    
	    
	    
	    
	    
	   
	    $time = time();
	    $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
	    $msgType = "text";
	    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);






	    return $resultStr;
	}

public function handleScan($postObj)
{
	$fromUsername = $postObj->FromUserName;
	$CreateTime = $postObj->CreateTime;
	$toUsername = $postObj->ToUserName;

	//$EventKey=$postObj->EventKey;
	$ScanResult = $postObj->ScanCodeInfo->ScanResult;






$time = time();

$newsTpl="
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
</Articles>
</xml>";
$file  = 'debug.txt';
file_put_contents($file, date("Y-m-d H:i:s",time()).$newsTpl."\r\n",FILE_APPEND);


			$title="设备信息查看";
			$description="这是一条测试数据";
			$PicUrl="http://wx.sishuixingchen.com/YWBD/1.png";
			$Url="http://wx.sishuixingchen.com/YWBD/scan.php?ID=$ScanResult";
			
	    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $title,$description,$PicUrl,$Url);

$file  = 'debug.txt';
file_put_contents($file, date("Y-m-d H:i:s",time()).$resultStr."\r\n",FILE_APPEND);



			echo $resultStr;
exit;


	}








	public function handleText($postObj)
	{
	    $fromUsername = $postObj->FromUserName;
	    $toUsername = $postObj->ToUserName;
	    $keyword = trim($postObj->Content);
	    $time = time();
	    $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";

		$http=parse_ini_file("conf.ini");// Êý¾Ý¿âÅäÖÃ
		$domain=$http['domain'];



	    if($keyword=='填表')
	    {
	        $contentStr='<a href="'.$domain.'/tianbiao.php?UserID='.$fromUsername.'">点击链接进入报名</a>';
	        goto res;
	    }

 	    if($keyword=='二维码')
 	    {
 	    		$domain="http://sishuixingchen.com/test";
 	        $contentStr='<a href="'.$domain.'/QRcode.php?UserID='.$fromUsername.'">点击链接查看我的邀请函</a>';
 	        goto res;
 	    }
// 	    if($keyword=='查看')
// 	    {
// 	        $contentStr='<a href="'.$domain.'/chakan.php">点击链接查看签到</a>';
// 	        goto res;
// 	    }
// 	    if($keyword=='check')
// 	    {
// 	        $contentStr='<a href="'.$domain.'/check.php?UserID='.$fromUsername.'">点击链接测试</a>';
// 	        goto res;
// 	    }
	    $link='<a href="'.$domain.'/tianbiao.php?UserID='.$fromUsername.'">点击链接进入资料完善</a>';
	    $contentStr = "欢迎关注家族智库™微信公众平台"."\n"."寻找专业顾问请留言【家族智库】"."\n";


	    res:   $msgType = "text";


	    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	    return $resultStr;



	}

















}

?>