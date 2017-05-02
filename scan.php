<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>扫描</title>
</head>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="/js/bootstrap.js"></script>
</head>


<?php
header("Content-Type: text/html; charset=utf-8");

$ID=$_GET['ID'];
?>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<body>


    <form id="form1" name="form1" action="submit.php" method="post" class="form-horizontal">
        <div class="form-group">
        <label class="col-sm-2 control-label">设备ID：</label>
        <div class="col-sm-10">
            <input name="ID"  readonly="readonly" type="text" class="form-control" placeholder="设备ID" value="<?php echo $ID;  ?>"/>
        </div>
            <br>
        <label class="col-sm-2 control-label">绑定内容：</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="绑定内容" name="Log" />
        </div>
        <br>
        <label class="col-sm-2 control-label">备注：</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="备注" name="Remark"/>
        </div>
        <br>
        </div>
        <div margin=30px>
        <button class="btn btn-primary" type="submit">提交</button>
        </div>
    </form>


</body>
</html>


