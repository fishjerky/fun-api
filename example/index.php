<?php
include_once('./init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Example</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://api.fun.wayi.com.tw/assets/jqplugin/v1.js"></script>
<style type="text/css">
body {
		background-color: #F4FAFF;
}
</style>
</head>

<body>
<script language="javascript">
$(function(){
	var options = {
		appId:"<?php echo $fun->getAppId();?>",
		access_token:"<?php echo $fun->getAccessToken();?>",
		max:5,
		title:"FUN名片邀請測試(標題)",
		content:"FUN名片邀請測試(內文)",
		accept_url:"http://fun.wayi.com.tw/userapp.php?appid=<?php echo $fun->getAppId();?>&redirect_uri=<?php urlencode("http://api.fun.wayi.com.tw/example/gift.php?itemkey=123")?>",
		action_url:"http://api.fun.wayi.com.tw/example/invites.php"
	};
	$("#invites").fun.invites(options);
	$(this).fun.iframe.setAutoResize();
});
</script>
<div style=" text-align:center;">
  <p><strong>FUN名片串接範例(淡藍色區塊都屬於外部應用程式範圍) </strong></p>
  <p><a href="user.php">取得個人資料(PHP)</a> | <a href="friends.php">取得好友(PHP)</a> | <a href="index.php">jQuery邀請朋友畫面</a> | <a href="flash.php">AS3存取API</a></p>
  <p>加入粉絲團：<iframe src="http://fun.wayi.com.tw/plugin/like.php?fanid=4864" width="150" height="40" scrolling="no" frameborder="0" allowtransparency="true" style="background-color:transparent;"></iframe></p>
  <p id="invites"></p>
  
  <p align="center">--------------------測試ifram高度自行延伸-----------------------</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">123</p>
  <p align="center">-------------------測試ifram高度自行延伸-----------------------</p>
</body>
</html>
