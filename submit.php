<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>扫描</title>
</head>
<?php
header("Content-Type: text/html; charset=utf-8");
$ID=$_POST['ID'];
$Log=$_POST['Log'];
$Remark=$_POST['Remark'];
	$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
	        file_put_contents("debug.txt", date("Y-m-d H:i:s",time()).$postStr."\r\n",FILE_APPEND);

require_once "../config/db.php";

$sql="insert  into YW_ScanLog (ID,Log,Remark) value ('$ID','$Log','$Remark');";

echo $sql;
file_put_contents("debug.txt", date("Y-m-d H:i:s",time()).$sql  ."\r\n",FILE_APPEND);

$result = $dbo->query($sql);

if (!$result){
echo "ErrorCode:".$dbo->errorCode()."<br>";
echo "ErrorInfo:";
print_r ($dbo->errorInfo());
}
else{
	$row = $result->fetch();
	echo "Sucess....";
}






?>

<style id="__wechat_default_css">::-webkit-scrollbar{    width: 10px;    height: 10px;    background-color: #FFF;}::-webkit-

scrollbar-button:start:decrement,::-webkit-scrollbar-button:end:increment{    display: block;}::-webkit-scrollbar-

button:vertical:start:increment,::-webkit-scrollbar-button:vertical:end:decrement{    display: none;}::-webkit-scrollbar-

button:end:increment{    background-color: transparent;}::-webkit-scrollbar-button:start:decrement{    background-color: 

transparent;}::-webkit-scrollbar-track-piece:vertical:start{    background-color: transparent;}::-webkit-scrollbar-track-

piece:vertical:end{    background-color: transparent;}::-webkit-scrollbar-thumb:vertical{    background: rgb(191, 191, 191);}

</style>



</body>
</html>


