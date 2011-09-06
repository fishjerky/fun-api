<?php
include_once('./init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Example</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://api.fun.wayi.com.tw/assets/jqplugin/v1.min.js"></script>
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
var  flashvars  = {} ;
flashvars.appid = "<?php echo $fun->getAppId();?>";
flashvars.access_token = "<?php echo $fun->getAccessToken();?>";
var params = {} ;
var attributes = {} ;
swfobject.embedSWF ("FUN_Example.swf","flash","620","500","9.0.0","expressInstall.swf",flashvars,params,attributes);
</script>
<style type="text/css">
body {
		background-color: #F4FAFF;
}
</style>
</head>

<body>
<script language="javascript">
$(window).load(function() {
	$(this).fun.iframe.setAutoResize();
});
</script>
<div style=" text-align:center;">
  <p><strong>FUN名片串接範例(淡藍色區塊都屬於外部應用程式範圍) </strong></p>
  <p><a href="user.php">取得個人資料(PHP)</a> | <a href="friends.php">取得好友(PHP)</a> | <a href="index.php">jQuery邀請朋友畫面</a> | <a href="flash.php">AS3存取API</a></p>
<div id="flash"></div>
</div>
</body>
</html>
