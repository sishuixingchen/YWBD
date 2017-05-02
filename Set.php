<?php
	session_set_cookie_params(24*3600);
	Session_start();

  date_default_timezone_set ('Asia/Chongqing');
  
  
  if((time()-$_SESSION["time"])/1000>=7200)
{  
  $appid='wxabb30016a608bdc0';
  $appsecret='e032ef2d4a66c0b9b93476dbf6d6fd97';
  $access_token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	$output=curl::HTTP_Connect($access_token_url,Null);
  echo "Session redim..<br>";
  $jsoninfo = json_decode($output, true);
	$access_token = $jsoninfo["access_token"];
  $_SESSION["access_token"]=$access_token;
  $_SESSION["time"]=time();
}
else 
{
	$access_token = $_SESSION["access_token"];
	echo "Session get..<br>";
}
  
  $url_menuadd="https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".$access_token;
   


$json='{
 	"button":[
   {
    "type": "scancode_waitmsg", 
    "name": "扫码查询", 
    "key": "Scan_Query", 
    "sub_button": [ ]
    },
	{ 
		"name":"菜单",
		"sub_button":[
    {
    "type": "scancode_waitmsg", 
    "name": "扫码提示", 
    "key": "rselfmenu_0_0"
    },
    {
    "type": "scancode_push", 
    "name": "扫码跳转", 
    "key": "rselfmenu_0_1"
    },
    {
    "type": "view", 
    "name": "跳至页面", 
		"url":"http://www.sishuixingchen.com/YWBD/scan.php"
    },
 		{
    "type": "pic_sysphoto", 
    "name": "拍照发图", 
    "key": "rselfmenu_1_0"
     }, 
		{
			"type":"view",
			"name":"系统后台",
			"url":"http://www.sishuixingchen.com/YWBD/index.php"
		}]
 }],
"matchrule":{
  "tag_id":"101",
  "sex":"",
  "country":"",
  "province":"",
  "city":"",
  "client_platform_type":"",
  "language":""
  }
}';


curl::HTTP_Connect($url_menuadd,$json);



class curl{
public static function HTTP_Connect($url,$json=0){	
$ch = curl_init();

	
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
echo $json."<br>";
$out = curl_exec($ch);
curl_close($ch);
echo $out."<br>";
file_put_contents("Set_log.txt", date("Y-m-d h:i:sa",time()).$out."\r\n",FILE_APPEND);
return $out;
}
}

    
    

?>